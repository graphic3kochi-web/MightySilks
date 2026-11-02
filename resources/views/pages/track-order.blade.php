@extends('layouts.site')

@section('title', 'Mighty Silks — Track Your Order')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Track Your Order</h1>
    </div>

    <!-- ============ Track order ============ -->
    <!-- No Figma frame for this page: the checkout's fields and the order page's progress line.
         js/main.js finds the order among those saved in this browser (checkout saves them) by its
         number and the email or phone used, and shows its progress worked out from the order
         date. No courier is connected. -->
    <section class="track" aria-labelledby="track-title">
      <div class="track__card">
        <h2 class="track__title" id="track-title">Find Your Order</h2>
        <p class="track__lead">Enter your order number and the email or phone number you used at checkout. Your order number is in your confirmation email, for example <strong>#MS123456</strong>.</p>

        <form class="track__form" data-track-form novalidate>
          <label class="checkout-field"><span>Order number</span><input type="text" name="order" required autocomplete="off" placeholder="MS123456" autocapitalize="characters"></label>
          <label class="checkout-field"><span>Email or phone number</span><input type="text" name="contact" required autocomplete="email" placeholder="you@example.com or 98765 43210"></label>
          <p class="login__status" role="alert" data-track-status></p>
          <button class="pdp-btn pdp-btn--solid track__submit" type="submit">Track Order</button>
        </form>

        <div class="track__recent" data-track-recent hidden>
          <p class="track__recent-title">Recent orders on this device</p>
          <div class="track__recent-list" data-track-recent-list></div>
        </div>
      </div>

      <!-- Result: filled by js/main.js. -->
      <div class="track__result" data-track-result tabindex="-1" hidden>
        <div class="track__result-head">
          <div>
            <p class="track__label">Order <strong data-track-number></strong></p>
            <h2 class="track__status" data-track-status-title></h2>
            <p class="track__eta" data-track-eta></p>
          </div>
          <a class="pdp-btn pdp-btn--outline track__details" href="order-details.html" data-track-details>View Order Details</a>
        </div>

        <ol class="order-steps track__steps" aria-label="Order progress" data-track-steps></ol>

        <div class="track__info">
          <div><p class="track__label">Items</p><div class="track__items" data-track-items></div></div>
          <div><p class="track__label">Shipping</p><p data-track-shipping></p></div>
          <div><p class="track__label">Delivering to</p><p data-track-address></p></div>
        </div>
      </div>

      <p class="track__help">Need help with your order? Visit our <a href="help-center.html">Help Center</a> or call us toll free on <a href="tel:800644489">800644489</a>.</p>
    </section>

  </main>
@endsection
