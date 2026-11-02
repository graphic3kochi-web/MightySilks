<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = User::where('is_admin', false)
            ->withCount('orders')->withSum(['orders' => fn ($q) => $q->where('status', '!=', 'cancelled')], 'total')
            ->when($request->q, fn ($q, $term) => $q->where(fn ($q) => $q
                ->where('name', 'like', "%$term%")->orWhere('email', 'like', "%$term%")->orWhere('phone', 'like', "%$term%")))
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.customers.index', ['customers' => $customers]);
    }

    public function show(User $customer)
    {
        abort_if($customer->is_admin, 404);

        return view('admin.customers.show', [
            'customer' => $customer,
            'orders' => $customer->orders()->withCount('items')->latest()->get(),
        ]);
    }

    /** Block or reinstate: a blocked customer can't sign in. */
    public function update(Request $request, User $customer)
    {
        abort_if($customer->is_admin, 404);
        $customer->update($request->validate(['status' => 'required|in:active,blocked']));

        return back()->with('status', "{$customer->name} is now {$customer->status}.");
    }
}
