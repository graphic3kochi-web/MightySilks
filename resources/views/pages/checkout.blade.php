@extends('layouts.site')

@section('title', 'Mighty Silks — Checkout')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Checkout</h1>
    </div>

    <!-- ============ Checkout ============ -->
    <!-- No Figma frame for this page: built in the cart page's style. js/main.js fills the order
         summary from the saved cart, works out shipping, shows the card fields for card payment
         and, once the form is valid, places the order (empties the cart, shows the thank-you). -->
    <section class="checkout" aria-label="Checkout" data-checkout>
      <form class="checkout__form" data-checkout-form>
        <fieldset class="checkout__group">
          <legend class="checkout__legend">Contact</legend>
          <div class="checkout__grid">
            <label class="checkout-field"><span>Email</span><input type="email" name="email" required autocomplete="email" data-checkout-email></label>
            <label class="checkout-field"><span>Phone</span><input type="tel" name="phone" required autocomplete="tel" pattern="[0-9+ ()-]{7,}"></label>
          </div>
        </fieldset>

        <fieldset class="checkout__group">
          <legend class="checkout__legend">Shipping Address</legend>
          <div class="checkout__grid">
            <label class="checkout-field checkout-field--full"><span>Country</span>
              <select name="country" required autocomplete="country-name">
                <option>India</option>
                <option>United Arab Emirates</option>
              </select>
            </label>
            <label class="checkout-field"><span>First name</span><input type="text" name="first-name" required autocomplete="given-name"></label>
            <label class="checkout-field"><span>Last name</span><input type="text" name="last-name" required autocomplete="family-name"></label>
            <label class="checkout-field checkout-field--full"><span>Address</span><input type="text" name="address" required autocomplete="address-line1"></label>
            <label class="checkout-field checkout-field--full"><span>Apartment, suite, etc. (optional)</span><input type="text" name="address-2" autocomplete="address-line2"></label>
            <label class="checkout-field"><span>City</span><input type="text" name="city" required autocomplete="address-level2"></label>
            <label class="checkout-field"><span>State / Emirate</span><input type="text" name="state" required autocomplete="address-level1"></label>
            <label class="checkout-field"><span>PIN code</span><input type="text" name="postal-code" required autocomplete="postal-code" inputmode="numeric"></label>
          </div>
        </fieldset>

        <fieldset class="checkout__group">
          <legend class="checkout__legend">Shipping Method</legend>
          <div class="checkout-options">
            <label class="checkout-option">
              <input type="radio" name="shipping" value="standard" checked>
              <span class="checkout-option__text"><strong>Standard Delivery</strong><small>5 – 7 business days · free on orders above ₹1,999</small></span>
              <span class="checkout-option__price" data-shipping-standard>Free</span>
            </label>
            <label class="checkout-option">
              <input type="radio" name="shipping" value="express">
              <span class="checkout-option__text"><strong>Express Delivery</strong><small>2 – 3 business days</small></span>
              <span class="checkout-option__price">₹ 250.00</span>
            </label>
          </div>
        </fieldset>

        <fieldset class="checkout__group">
          <legend class="checkout__legend">Payment</legend>
          <p class="checkout__note">All transactions are secure and encrypted.</p>
          <div class="checkout-options">
            <label class="checkout-option">
              <input type="radio" name="payment" value="upi" checked>
              <span class="checkout-option__text"><strong>UPI</strong><small>Google Pay, PhonePe, Paytm and more</small></span>
            </label>
            <label class="checkout-option">
              <input type="radio" name="payment" value="card">
              <span class="checkout-option__text"><strong>Credit / Debit Card</strong><small>Visa, Mastercard, RuPay</small></span>
            </label>
            <div class="checkout-card" data-checkout-card hidden>
              <div class="checkout__grid">
                <label class="checkout-field checkout-field--full"><span>Card number</span><input type="text" name="card-number" autocomplete="cc-number" inputmode="numeric" pattern="[0-9 ]{12,23}" placeholder="1234 5678 9012 3456"></label>
                <label class="checkout-field checkout-field--full"><span>Name on card</span><input type="text" name="card-name" autocomplete="cc-name"></label>
                <label class="checkout-field"><span>Expiry (MM / YY)</span><input type="text" name="card-expiry" autocomplete="cc-exp" pattern="(0[1-9]|1[0-2]) ?/ ?[0-9]{2}" placeholder="MM / YY"></label>
                <label class="checkout-field"><span>CVV</span><input type="password" name="card-cvv" autocomplete="cc-csc" inputmode="numeric" pattern="[0-9]{3,4}"></label>
              </div>
            </div>
            <label class="checkout-option">
              <input type="radio" name="payment" value="cod">
              <span class="checkout-option__text"><strong>Cash on Delivery</strong><small>Pay when your order arrives</small></span>
            </label>
          </div>
        </fieldset>

        <div class="checkout__actions">
          <a class="checkout__back" href="cart.html">‹ Return to cart</a>
          <button class="pdp-btn pdp-btn--solid checkout__submit" type="submit">Place Order</button>
        </div>
        <p class="checkout__error" role="alert" data-checkout-status></p>
      </form>

      <aside class="checkout-summary" aria-labelledby="checkout-summary-title">
        <h2 class="checkout-summary__title" id="checkout-summary-title">Order Summary</h2>
        <ul class="checkout-summary__items" data-checkout-items>
          <li class="checkout-item">
            <span class="checkout-item__photo"><img src="assets/cart/item-1.png" alt=""><span class="checkout-item__qty">1</span></span>
            <p class="checkout-item__name">Semi Silk Peacock Blue Saree with Silver Zari Woven Pallu and Green Zari Border</p>
            <p class="checkout-item__price">₹ 2,480.00</p>
          </li>
          <li class="checkout-item">
            <span class="checkout-item__photo"><img src="assets/cart/item-2.png" alt=""><span class="checkout-item__qty">1</span></span>
            <p class="checkout-item__name">Semi Silk Sea Green Golden Zari Pallu Saree with Paisley Butta Body and Teal Border</p>
            <p class="checkout-item__price">₹ 2,480.00</p>
          </li>
          <li class="checkout-item">
            <span class="checkout-item__photo"><img src="assets/cart/item-3.png" alt=""><span class="checkout-item__qty">1</span></span>
            <p class="checkout-item__name">Organza Cream Watercolor Pink Floral Printed Saree with Stone Studded Scalloped Border</p>
            <p class="checkout-item__price">₹ 3,330.00</p>
          </li>
          <li class="checkout-item">
            <span class="checkout-item__photo"><img src="assets/cart/item-4.png" alt=""><span class="checkout-item__qty">1</span></span>
            <p class="checkout-item__name">Organza Cream Teal Blue and Olive Golden Wavy Stripe Printed Saree with Beaded Scalloped Border</p>
            <p class="checkout-item__price">₹ 3,330.00</p>
          </li>
        </ul>

        <form class="checkout-coupon" data-checkout-coupon>
          <label class="visually-hidden" for="checkout-coupon">Discount code</label>
          <input id="checkout-coupon" type="text" name="coupon" placeholder="Discount code (try NEW10)" autocomplete="off" data-checkout-coupon-input>
          <button class="pdp-btn pdp-btn--outline" type="submit" data-checkout-coupon-apply>Apply</button>
          <p class="checkout-coupon__status" role="status" data-checkout-coupon-status></p>
        </form>

        <dl class="checkout-summary__rows">
          <div><dt>Subtotal</dt><dd data-checkout-subtotal>₹ 11,620.00</dd></div>
          <div data-checkout-discount-row hidden><dt>Discount (NEW10)</dt><dd data-checkout-discount>− ₹ 0.00</dd></div>
          <div><dt>Shipping</dt><dd data-checkout-shipping>Free</dd></div>
          <div class="checkout-summary__total"><dt>Total</dt><dd data-checkout-total>₹ 11,620.00</dd></div>
        </dl>
        <p class="checkout-summary__tax">Tax included.</p>
      </aside>
    </section>

    <div class="checkout-message" data-checkout-empty hidden>
      <h2>Your cart is empty.</h2>
      <p>Add a few favourites before checking out.</p>
      <a class="pdp-btn pdp-btn--solid" href="our-shop.html">Continue Shopping</a>
    </div>

    <div class="checkout-message" data-checkout-done tabindex="-1" hidden>
      <h2>Thank you for your order!</h2>
      <p>Order <strong data-checkout-order-number></strong> is confirmed. A confirmation has been sent to <strong data-checkout-order-email></strong>.</p>
      <a class="pdp-btn pdp-btn--solid" href="our-shop.html">Continue Shopping</a>
    </div>

  </main>
@endsection
