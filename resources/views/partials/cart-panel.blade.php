<!-- Cart drawer: slides in from the right, opened by the header bag button and every Add to Cart /
     Buy Now button (js/main.js renders the items, deals and totals). -->
<div class="cart-panel" id="cart-panel" hidden>
  <div class="cart-panel__backdrop" data-cart-close></div>
  <aside class="cart-drawer" role="dialog" aria-modal="true" aria-labelledby="cart-title" tabindex="-1">
    <header class="cart-drawer__head">
      <svg class="cart-drawer__icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2.4 10.2a1 1 0 0 0 1 .8h8.9a1 1 0 0 0 1-.8L20 7H6.2"/><circle cx="9.5" cy="19" r="1.4"/><circle cx="17" cy="19" r="1.4"/></svg>
      <h2 class="cart-drawer__title" id="cart-title">Your cart <span data-cart-count>(0 items)</span></h2>
      <button class="cart-drawer__close" type="button" aria-label="Close cart" data-cart-close>
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
      </button>
    </header>

    <div class="cart-drawer__body">
      <ul class="cart-list" data-cart-list></ul>
      <p class="cart-empty" data-cart-empty hidden>Your cart is empty.</p>

      <div class="cart-extras" data-cart-extras>
        {{-- The featured coupon (Admin › Coupons); without one the offer card stays hidden. --}}
        <div class="cart-card cart-coupon" data-coupon{{ $shop['coupon'] ? '' : ' hidden' }}>
          <svg class="cart-coupon__badge" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l2.4 1.8 3-.2.9 2.9 2.5 1.7-1 2.8 1 2.8-2.5 1.7-.9 2.9-3-.2L12 22l-2.4-1.8-3 .2-.9-2.9-2.5-1.7 1-2.8-1-2.8 2.5-1.7.9-2.9 3 .2z"/><path class="cart-coupon__mark" d="M9 15l6-6M9.5 9.5h.01M14.5 14.5h.01"/></svg>
          <div class="cart-coupon__text">
            <p class="cart-coupon__title"><span class="cart-coupon__offer">Save <span data-coupon-saving>₹0</span> with <strong>{{ $shop['coupon']['code'] ?? '' }}</strong></span><span class="cart-coupon__done"><strong>{{ $shop['coupon']['code'] ?? '' }}</strong> applied · you save <span data-coupon-saving>₹0</span></span></p>
            <p class="cart-coupon__sub">Coupons and offers</p>
          </div>
          <button class="cart-coupon__apply" type="button" aria-pressed="false" data-coupon-apply>Apply</button>
        </div>

        <label class="cart-card cart-gift">
          <input type="checkbox" name="gift-card">
          <span><strong>Redeem gift card?</strong><small>Select this to apply gift card in next step</small></span>
        </label>

        <section class="cart-deals" aria-labelledby="cart-deals-title">
          <h3 class="cart-deals__title" id="cart-deals-title"><span aria-hidden="true">🔥</span> Top deals of the day</h3>
          <ul class="cart-deals__list" data-cart-deals></ul>
        </section>

        <div class="cart-card cart-note">
          <button class="cart-note__toggle" type="button" aria-expanded="false" aria-controls="cart-note" data-cart-note-toggle>
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"/><path d="M18.4 2.6a2 2 0 0 1 2.9 2.9L12 14.8l-3.8 1 1-3.8z"/></svg>
            Order instructions<span class="cart-note__add">Add</span>
          </button>
          <label class="visually-hidden" for="cart-note">Order instructions</label>
          <textarea class="cart-note__field" id="cart-note" rows="3" placeholder="E.g. gift wrap, delivery notes…" data-cart-note hidden></textarea>
        </div>

        <section class="cart-bill" aria-labelledby="cart-bill-title" data-cart-bill>
          <h3 class="cart-bill__title" id="cart-bill-title">Bill summary</h3>
          <p class="cart-bill__row">
            <span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2z"/><path d="M9 8h6M9 12h6"/></svg><span>Cart total (<span data-cart-items>0 items</span>)</span></span>
            <span data-cart-subtotal>₹0</span>
          </p>
          <p class="cart-bill__row cart-bill__row--discount" data-cart-discount-row hidden><span>Coupon ({{ $shop['coupon']['code'] ?? '' }})</span><span data-cart-discount>−₹0</span></p>
          <p class="cart-bill__grand"><span>Grand Total</span><strong data-cart-total>₹0</strong></p>
        </section>
      </div>
    </div>

    <footer class="cart-drawer__foot">
      <div class="cart-foot__total">
        <strong data-cart-total>₹0</strong>
        <button type="button" data-cart-view-details>View Details</button>
      </div>
      <a class="cart-checkout" href="checkout.html" data-cart-checkout>Checkout</a>
      <p class="cart-secure"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>Secure checkout</p>
    </footer>
  </aside>
</div>
