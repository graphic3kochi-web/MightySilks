@extends('layouts.admin')

@section('title', "Order #$order->number")
@section('crumb', "Order #$order->number")

@section('content')
<div class="adm-head">
  <div>
    <h1>Order #{{ $order->number }}</h1>
    <p>Placed {{ $order->created_at->format('d M Y, H:i') }} · {{ $order->created_at->diffForHumans() }}</p>
  </div>
  <div class="adm-head__actions">
    <span class="adm-badge adm-badge--{{ $order->status }}">{{ \App\Models\Order::STATUSES[$order->status] }}</span>
    <span class="adm-badge adm-badge--{{ $order->payment_status }}">{{ \App\Models\Order::PAYMENT_STATUSES[$order->payment_status] }}</span>
    <a class="adm-btn adm-btn--ghost" href="{{ url('order-details.html?order='.$order->number) }}" target="_blank" rel="noopener"><i class="fa-solid fa-arrow-up-right-from-square"></i> Customer view</a>
    <a class="adm-btn" href="{{ route('admin.orders.invoice', $order) }}"><i class="fa-solid fa-file-invoice"></i> Download Invoice</a>
  </div>
</div>

<div class="adm-detail">
  <div>
    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon"><i class="fa-solid fa-bag-shopping"></i></span><h2 class="adm-card__title">Items</h2></div>
      <div class="adm-table-wrap">
        <table class="adm-table">
          <thead><tr><th>Product</th><th class="num">Price</th><th class="num">Qty</th><th class="num">Total</th></tr></thead>
          <tbody>
            @foreach ($order->items as $item)
              <tr>
                <td>
                  <div class="adm-cell">
                    @if ($item->image)<img class="adm-thumb" src="{{ asset($item->image) }}" alt="">@endif
                    <span>
                      @if ($item->product)<a href="{{ route('admin.products.edit', $item->product) }}">{{ $item->name }}</a>@else{{ $item->name }}@endif
                      <br><span class="muted">{{ $item->product_code }}</span>
                    </span>
                  </div>
                </td>
                <td class="num">{{ inr($item->price) }}</td>
                <td class="num">{{ $item->qty }}</td>
                <td class="num"><strong>{{ inr($item->price * $item->qty) }}</strong></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div style="max-width:340px; margin:14px 0 0 auto">
        <p class="adm-total"><span>Subtotal</span><span>{{ inr($order->subtotal) }}</span></p>
        @if ((float) $order->discount)
          <p class="adm-total"><span>Discount ({{ $order->coupon_code }})</span><span>− {{ inr($order->discount) }}</span></p>
        @endif
        <p class="adm-total"><span>{{ $order->shipping_label }}</span><span>{{ (float) $order->shipping ? inr($order->shipping) : 'Free' }}</span></p>
        <p class="adm-total adm-total--grand"><span>Total</span><span>{{ inr($order->total) }}</span></p>
      </div>
    </section>

    @if ($order->note)
      <section class="adm-card">
        <div class="adm-card__head"><span class="adm-card__icon adm-card__icon--gold"><i class="fa-solid fa-note-sticky"></i></span><h2 class="adm-card__title">Order instructions</h2></div>
        <p class="adm-prose">{{ $order->note }}</p>
      </section>
    @endif
  </div>

  <div>
    <form class="adm-card" method="post" action="{{ route('admin.orders.update', $order) }}" data-confirm="Update this order?">
      @csrf @method('put')
      <div class="adm-card__head"><span class="adm-card__icon adm-card__icon--teal"><i class="fa-solid fa-truck-fast"></i></span><h2 class="adm-card__title">Fulfilment</h2></div>
      <div class="adm-grid" style="grid-template-columns:1fr">
        <x-admin.field name="status" label="Order status" :options="\App\Models\Order::STATUSES" :value="$order->status" help="The customer sees this on Track Your Order. Cancelling returns the items to stock." />
        <x-admin.field name="payment_status" label="Payment" :options="\App\Models\Order::PAYMENT_STATUSES" :value="$order->payment_status" />
      </div>
      <dl class="adm-dl" style="margin-top:14px">
        <dt>Packed</dt><dd>{{ $order->packed_at?->format('d M Y H:i') ?? '—' }}</dd>
        <dt>Shipped</dt><dd>{{ $order->shipped_at?->format('d M Y H:i') ?? '—' }}</dd>
        <dt>Delivered</dt><dd>{{ $order->delivered_at?->format('d M Y H:i') ?? '—' }}</dd>
      </dl>
      <div class="adm-form__bar"><button class="adm-btn" type="submit">Save</button></div>
    </form>

    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon"><i class="fa-solid fa-user"></i></span><h2 class="adm-card__title">Customer</h2></div>
      <dl class="adm-dl">
        <dt>Name</dt><dd>{{ $order->customerName() }}</dd>
        <dt>Email</dt><dd><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></dd>
        <dt>Phone</dt><dd>{{ $order->phone }}</dd>
        <dt>Account</dt><dd>@if ($order->user)<a href="{{ route('admin.customers.show', $order->user) }}">{{ $order->user->name }}</a>@else Guest checkout @endif</dd>
        <dt>Ship to</dt><dd>{{ $order->address }}@if ($order->address_2), {{ $order->address_2 }}@endif<br>{{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}<br>{{ $order->country }}</dd>
        <dt>Payment</dt><dd>{{ $order->payment_label }}</dd>
      </dl>
    </section>
  </div>
</div>
@endsection
