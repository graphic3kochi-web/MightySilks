<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlaced;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

/** Checkout (checkout.html), order details, invoices, My Orders and order tracking. */
class OrderController extends Controller
{
    /**
     * Takes the order: prices come from the catalogue (never the browser), stock is checked and
     * reserved, the coupon and shipping follow the same rules the checkout page shows.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1|max:50',
            'items.*.id' => 'required|string|max:40',
            'items.*.qty' => 'required|integer|min:1|max:20',
            'coupon' => 'nullable|string|max:40',
            'email' => 'required|email|max:120',
            'phone' => 'required|string|max:30',
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'address' => 'required|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:80',
            'state' => 'required|string|max:80',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:80',
            'shipping' => 'required|in:standard,express',
            'shipping_label' => 'required|string|max:80',
            'payment' => 'required|in:upi,card,cod',
            'payment_label' => 'required|string|max:80',
            'card_last4' => 'nullable|required_if:payment,card|digits:4',
            'note' => 'nullable|string|max:1000',
        ]);

        $order = DB::transaction(function () use ($data, $request) {
            $lines = collect($data['items'])->groupBy('id')->map(fn ($rows) => $rows->sum('qty'));
            $products = Product::active()->whereIn('code', $lines->keys())->lockForUpdate()->get()->keyBy('code');

            $subtotal = 0;
            foreach ($lines as $code => $qty) {
                $product = $products[$code] ?? null;
                if (! $product) {
                    throw ValidationException::withMessages(['items' => 'An item in your cart is no longer available. Please remove it and try again.']);
                }
                if ($product->stock < $qty) {
                    throw ValidationException::withMessages(['items' => $product->stock
                        ? "Only {$product->stock} left of “{$product->title}”. Please lower the quantity."
                        : "“{$product->title}” is sold out. Please remove it from your cart."]);
                }
                $subtotal += $product->price * $qty;
            }

            $coupon = null;
            if ($data['coupon'] ?? null) {
                $coupon = Coupon::where('code', strtoupper($data['coupon']))->lockForUpdate()->first();
                $problem = $coupon ? $coupon->problemFor($subtotal) : 'That code isn\'t valid.';
                if ($problem) {
                    throw ValidationException::withMessages(['coupon' => $problem]);
                }
            }
            $discount = $coupon ? round($subtotal * $coupon->percent / 100) : 0;
            $rates = Setting::shipping();
            $shipping = $data['shipping'] === 'express' ? $rates['express'] : ($subtotal - $discount >= $rates['freeFrom'] ? 0 : $rates['standard']);

            $order = Order::create([
                'number' => $this->newNumber(),
                'user_id' => $request->user()?->id ?? User::where('email', strtolower($data['email']))->value('id'),
                'status' => 'placed',
                'payment_status' => 'pending',
                'payment_method' => $data['payment'],
                'payment_label' => $data['payment'] === 'card' ? "Card ending {$data['card_last4']}" : $data['payment_label'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'address' => $data['address'],
                'address_2' => $data['address_2'] ?? null,
                'city' => $data['city'],
                'state' => $data['state'],
                'postal_code' => $data['postal_code'],
                'country' => $data['country'],
                'shipping_method' => $data['shipping'],
                'shipping_label' => $data['shipping_label'],
                'coupon_code' => $coupon?->code,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping' => $shipping,
                'total' => $subtotal - $discount + $shipping,
                'note' => $data['note'] ?? null,
            ]);
            foreach ($lines as $code => $qty) {
                $product = $products[$code];
                $order->items()->create([
                    'product_id' => $product->id,
                    'product_code' => $code,
                    'name' => $product->page_title ?: $product->title,
                    'image' => $product->image(),
                    'price' => $product->price,
                    'qty' => $qty,
                ]);
                $product->decrement('stock', $qty);
            }
            $coupon?->increment('used_count');

            return $order;
        });

        // This browser may look the order up again (order-details.html) without signing in.
        $request->session()->push('orders', $order->number);

        // Confirmation with the PDF invoice; the store gets a copy at MAIL_ORDER_RECIPIENT (.env)
        // and the Settings order notify address. A mail failure is logged but never fails the
        // order, which is already placed.
        try {
            $store = collect(explode(',', config('mail.order_recipient').','.Setting::get('order_notify_email')))
                ->map(fn ($email) => trim($email))->filter()->unique()->values()->all();
            Mail::to($order->email)->bcc($store)->send(new OrderPlaced($order->load('items')));
        } catch (\Throwable $e) {
            report($e);
        }

        return response()->json(['order' => $order->load('items')->toRecord()], 201);
    }

    /** order-details.html: for the shopper who placed it (this session or their account) or an admin. */
    public function show(Request $request, string $number)
    {
        return ['order' => $this->findViewable($request, $number)->toRecord()];
    }

    /** orders/<number>/invoice: the PDF invoice, for the same people who may see the order. */
    public function invoice(Request $request, string $number)
    {
        $order = $this->findViewable($request, $number);

        return $order->invoicePdf()->download($order->invoiceFilename());
    }

    /** my-orders.html: the signed-in shopper's orders, newest first, each with its invoice. */
    public function mine(Request $request)
    {
        $user = $request->user();
        $orders = $user
            ? Order::with('items')->where('user_id', $user->id)->latest()->get()
            : null;

        return view('account.orders', compact('orders'));
    }

    /** track-order.html: the order number plus the email or phone used at checkout. */
    public function track(Request $request)
    {
        $data = $request->validate(['order' => 'required|string|max:30', 'contact' => 'required|string|max:120']);
        $order = Order::with('items')->where('number', strtoupper(ltrim(trim($data['order']), '#')))->first();
        $contact = strtolower(trim($data['contact']));
        $phone = User::phoneKey($contact);

        $matches = $order && (strtolower($order->email) === $contact || (strlen($phone) >= 7 && User::phoneKey($order->phone) === $phone));
        if (! $matches) {
            return response()->json(['message' => 'We couldn\'t find an order with those details. Please check your order number and the email or phone you used.'], 404);
        }

        return ['order' => $order->toRecord()];
    }

    /** The order, if this session placed it, it's on the signed-in shopper's account, or an admin asks. */
    private function findViewable(Request $request, string $number): Order
    {
        $order = Order::with('items')->where('number', strtoupper($number))->firstOrFail();
        $user = $request->user();
        $allowed = in_array($order->number, $request->session()->get('orders', []), true)
            || ($user && ($user->is_admin || $order->user_id === $user->id));
        abort_unless($allowed, 404);

        return $order;
    }

    private function newNumber(): string
    {
        do {
            $number = 'MS'.random_int(100000, 999999);
        } while (Order::where('number', $number)->exists());

        return $number;
    }
}
