@extends('layouts.site')

@section('title', 'Mighty Silks — My Orders')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <div class="shop-hero">
      <h1 class="shop-hero__title">My Orders</h1>
    </div>

    <!-- The signed-in shopper's orders (Shop\OrderController::mine), newest first, each with its
         details page and PDF invoice. Built in the track order page's style. -->
    <section class="my-orders" aria-label="My orders">
      @if ($orders === null)
        <div class="track__card my-orders__empty">
          <h2 class="track__title">Log in to see your orders</h2>
          <p class="track__lead">Your order history and invoices are kept on your account. Ordered as a guest? You can still <a href="track-order.html">track an order</a> with its number.</p>
          <div class="my-orders__cta">
            <a class="pdp-btn pdp-btn--solid" href="login.html">Log In</a>
            <a class="pdp-btn pdp-btn--outline" href="signup.html">Create Account</a>
          </div>
        </div>
      @elseif ($orders->isEmpty())
        <div class="track__card my-orders__empty">
          <h2 class="track__title">No orders yet</h2>
          <p class="track__lead">When you place an order with <strong>{{ auth()->user()->email }}</strong>, it shows here with its invoice.</p>
          <div class="my-orders__cta"><a class="pdp-btn pdp-btn--solid" href="our-shop.html">Start Shopping</a></div>
        </div>
      @else
        <p class="my-orders__lead">{{ $orders->count() }} {{ Str::plural('order', $orders->count()) }} on <strong>{{ auth()->user()->email }}</strong></p>
        <ul class="my-orders__list">
          @foreach ($orders as $order)
            <li class="my-order">
              <div class="my-order__head">
                <div>
                  <p class="track__label">Order <strong>#{{ $order->number }}</strong> · {{ $order->created_at->format('d M Y') }}</p>
                  <p class="my-order__status my-order__status--{{ $order->status }}">{{ \App\Models\Order::STATUSES[$order->status] }}</p>
                </div>
                <p class="my-order__total"><span class="track__label">Total</span>{{ inr($order->total) }}</p>
              </div>
              <div class="my-order__body">
                <div class="track__items">
                  @foreach ($order->items->take(4) as $item)
                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" title="{{ $item->name }}">
                  @endforeach
                  <span>{{ $order->itemCount() }} {{ Str::plural('item', $order->itemCount()) }}@if ($order->items->count() > 4) · +{{ $order->items->count() - 4 }} more @endif</span>
                </div>
                <div class="my-order__actions">
                  <a class="pdp-btn pdp-btn--outline" href="order-details.html?order={{ $order->number }}">View Details</a>
                  <a class="pdp-btn pdp-btn--solid" href="{{ route('orders.invoice', $order->number) }}">Download Invoice</a>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      @endif
    </section>

  </main>
@endsection
