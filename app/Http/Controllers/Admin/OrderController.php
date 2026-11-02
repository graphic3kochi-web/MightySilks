<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::withCount('items')
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->when($request->q, fn ($q, $term) => $q->where(fn ($q) => $q
                ->where('number', 'like', "%$term%")->orWhere('email', 'like', "%$term%")
                ->orWhere('phone', 'like', "%$term%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$term%"])))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'counts' => Order::selectRaw('status, COUNT(*) c')->groupBy('status')->pluck('c', 'status'),
        ]);
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', ['order' => $order->load('items.product', 'user')]);
    }

    public function invoice(Order $order)
    {
        return $order->invoicePdf()->download($order->invoiceFilename());
    }

    /** Moves the order along (stamping when it was packed / shipped / delivered) and its payment. */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::STATUSES))],
            'payment_status' => ['required', Rule::in(array_keys(Order::PAYMENT_STATUSES))],
        ]);

        $step = array_search($data['status'], ['placed', 'packed', 'shipped', 'delivered'], true);
        foreach (['packed_at' => 1, 'shipped_at' => 2, 'delivered_at' => 3] as $column => $at) {
            if ($step !== false && $step >= $at) {
                $order->{$column} ??= now();
            }
        }
        // Cancelling puts the stock back; reinstating a cancelled order takes it again.
        $cancelling = $data['status'] === 'cancelled' && $order->status !== 'cancelled';
        $reinstating = $data['status'] !== 'cancelled' && $order->status === 'cancelled';
        if ($cancelling || $reinstating) {
            foreach ($order->items as $item) {
                $item->product?->increment('stock', $cancelling ? $item->qty : -$item->qty);
            }
        }
        $order->fill($data)->save();

        return back()->with('status', "Order #$order->number updated.");
    }
}
