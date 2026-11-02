@extends('layouts.site')

@section('title', 'Mighty Silks — Order Details')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Order Details</h1>
    </div>

    <!-- ============ Order details ============ -->
    <!-- No Figma frame for this page: built in the cart / checkout style. js/main.js fills it from
         the order saved at checkout (order-details.html?order=<number>). -->
    <section class="order" aria-label="Order details" data-order-page>
      <div class="order__head">
        <span class="order__check" aria-hidden="true">
          <svg viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>
        </span>
        <div class="order__intro">
          <h2 class="order__greeting" data-order-greeting>Thank you!</h2>
          <p class="order__lead">Order <strong data-order-number></strong> was placed on <span data-order-date></span>. A confirmation has been sent to <strong data-order-email></strong>.</p>
        </div>
        <div class="order__actions">
          <button class="pdp-btn pdp-btn--outline" type="button" data-order-print>Print</button>
          <a class="pdp-btn pdp-btn--outline" href="#" data-order-invoice hidden>Download Invoice</a>
          <a class="pdp-btn pdp-btn--solid" href="our-shop.html">Continue Shopping</a>
        </div>
      </div>

      <ol class="order-steps" aria-label="Order progress">
        <li class="order-step is-done"><span class="order-step__dot" aria-hidden="true"></span><strong>Order Placed</strong><small data-order-placed></small></li>
        <li class="order-step is-current" aria-current="step"><span class="order-step__dot" aria-hidden="true"></span><strong>Packed</strong><small>Within 48 business hours</small></li>
        <li class="order-step"><span class="order-step__dot" aria-hidden="true"></span><strong>Shipped</strong><small>Tracking link by email</small></li>
        <li class="order-step"><span class="order-step__dot" aria-hidden="true"></span><strong>Delivered</strong><small data-order-arrives></small></li>
      </ol>

      <div class="order__body">
        <div class="order__main">
          <h2 class="order__title">Items</h2>
          <ul class="order__items" data-order-items></ul>

          <div class="order-info">
            <div class="order-info__card">
              <h3>Contact</h3>
              <p data-order-contact></p>
            </div>
            <div class="order-info__card">
              <h3>Shipping Address</h3>
              <address data-order-address></address>
            </div>
            <div class="order-info__card">
              <h3>Shipping Method</h3>
              <p data-order-shipping-method></p>
            </div>
            <div class="order-info__card">
              <h3>Payment</h3>
              <p data-order-payment></p>
            </div>
          </div>
        </div>

        <aside class="checkout-summary order__summary" aria-labelledby="order-summary-title">
          <h2 class="checkout-summary__title" id="order-summary-title">Order Summary</h2>
          <dl class="checkout-summary__rows">
            <div><dt>Subtotal</dt><dd data-order-subtotal></dd></div>
            <div data-order-discount-row hidden><dt data-order-discount-label>Discount</dt><dd data-order-discount></dd></div>
            <div><dt>Shipping</dt><dd data-order-shipping></dd></div>
            <div class="checkout-summary__total"><dt>Total</dt><dd data-order-total></dd></div>
          </dl>
          <p class="checkout-summary__tax">Tax included.</p>
          <p class="order__help">Need help with this order? Call <a href="tel:800644489">800644489</a> or email <a href="mailto:info@mightysilks.ae">info@mightysilks.ae</a>.</p>
        </aside>
      </div>
    </section>

    <div class="checkout-message" data-order-missing hidden>
      <h2>We couldn't find that order.</h2>
      <p>Orders placed on this device show here after checkout.</p>
      <a class="pdp-btn pdp-btn--solid" href="our-shop.html">Continue Shopping</a>
    </div>

  </main>
@endsection
