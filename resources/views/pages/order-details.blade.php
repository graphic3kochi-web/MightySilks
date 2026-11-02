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
         the order saved at checkout (/order-details?order=<number>). -->
    <section class="order" aria-label="Order details" data-order-page>
      <div class="order__head">
        <span class="order__check" aria-hidden="true" data-order-check>
          <svg viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>
        </span>
        <div class="order__intro">
          <h2 class="order__greeting" data-order-greeting>Thank you!</h2>
          <p class="order__lead" data-order-lead>Order <strong data-order-number></strong> was placed on <span data-order-date></span>. A confirmation has been sent to <strong data-order-email></strong>.</p>
          <p class="order__lead" data-order-cancelled-lead hidden>Order <strong data-order-number></strong> placed on <span data-order-date></span> has been cancelled. Any payment you made will be refunded to the original method within 5–7 business days.</p>
        </div>
        <div class="order__actions">
          <button class="pdp-btn pdp-btn--outline order__cancel" type="button" data-order-cancel hidden>Cancel Order</button>
          <button class="pdp-btn pdp-btn--outline" type="button" data-order-print>Print</button>
          <a class="pdp-btn pdp-btn--outline" href="#" data-order-invoice hidden>Download Invoice</a>
          <a class="pdp-btn pdp-btn--solid" href="our-shop">Continue Shopping</a>
        </div>
      </div>

      <!-- Progress: js/main.js marks the steps from the order's status (or hides them once cancelled). -->
      <ol class="order-steps" aria-label="Order progress" data-order-steps>
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

    <!-- Cancel Order: confirm, with an optional reason (the product page's review dialog style). -->
    <dialog class="review-dialog order-cancel" aria-labelledby="order-cancel-title" data-order-cancel-dialog>
      <button class="review-dialog__close" type="button" aria-label="Close" data-order-cancel-close>
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
      </button>
      <form class="order-cancel__form" data-order-cancel-form novalidate>
        <h2 class="review-dialog__title" id="order-cancel-title">Cancel this order?</h2>
        <p class="review-dialog__lead">Order <strong data-order-number></strong> hasn't been packed yet, so you can cancel it free of charge. The items go back on sale, and any payment you made is refunded within 5–7 business days.</p>
        <label class="review-field order-cancel__reason"><span>Reason (optional)</span>
          <select name="reason">
            <option value="">Choose a reason</option>
            <option>Ordered by mistake</option>
            <option>Found a better price elsewhere</option>
            <option>Delivery will take too long</option>
            <option>Want to change items or size</option>
            <option>Want to change the delivery address</option>
            <option>Other</option>
          </select>
        </label>
        <p class="review-form__error" role="alert" data-order-cancel-error></p>
        <div class="order-cancel__actions">
          <button class="pdp-btn pdp-btn--outline" type="button" data-order-cancel-close>Keep Order</button>
          <button class="pdp-btn pdp-btn--solid" type="submit" data-order-cancel-submit>Yes, Cancel Order</button>
        </div>
      </form>
    </dialog>

    <div class="checkout-message" data-order-missing hidden>
      <h2>We couldn't find that order.</h2>
      <p>Orders placed on this device show here after checkout.</p>
      <a class="pdp-btn pdp-btn--solid" href="our-shop">Continue Shopping</a>
    </div>

  </main>
@endsection
