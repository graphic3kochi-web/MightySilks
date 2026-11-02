@extends('layouts.site')

@section('title', 'Mighty Silks — Purchasing Guide')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Purchasing Guide</h1>
    </div>

    <!-- ============ Purchasing guide ============ -->
    <!-- No Figma frame for this page: numbered step cards, then the About, CSR and Help Center
         pages' sections. The details match the checkout and the policy pages. -->

    <!-- Steps: how to buy, six numbered cards. -->
    <section class="buy-steps" aria-labelledby="buy-steps-title">
      <p class="about-eyebrow">Shopping Made Simple</p>
      <h2 class="about-heading" id="buy-steps-title">How to Place an Order</h2>
      <p class="buy-steps__lead">Finding and ordering your perfect saree, lehenga or gown takes just a few minutes. Here's how it works.</p>
      <ol class="buy-steps__list">
        <li class="buy-step">
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
          <h3>Browse &amp; Discover</h3>
          <p>Explore <a href="our-shop">Our Shop</a>, <a href="new-arrivals">New Arrivals</a> or a collection, or use the search in the header. Filter by price, colour and pattern to narrow your choice.</p>
        </li>
        <li class="buy-step">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
          <h3>View the Details</h3>
          <p>Open a product or use <strong>Quick View</strong> to see more photos, the price, fabric and whether a blouse piece is included. Tap the heart to save it to your wishlist.</p>
        </li>
        <li class="buy-step">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2.4 10.2a1 1 0 0 0 1 .8h8.9a1 1 0 0 0 1-.8L20 7H6.2"/><circle cx="9.5" cy="19" r="1.4"/><circle cx="17" cy="19" r="1.4"/></svg>
          <h3>Add to Cart</h3>
          <p>Click <strong>Add to Cart</strong> to keep shopping, or <strong>Buy Now</strong> to check out that piece straight away. Review your cart and apply a coupon such as <strong>NEW10</strong>.</p>
        </li>
        <li class="buy-step">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7-6.2-7-12a7 7 0 0 1 14 0c0 5.8-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>
          <h3>Enter Your Details</h3>
          <p>At checkout, add your email, phone and delivery address, then choose Standard or Express Delivery. You can check out as a guest or <a href="login">log in</a> for faster checkout.</p>
        </li>
        <li class="buy-step">
          <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18M7 15h4"/></svg>
          <h3>Pay Securely</h3>
          <p>Pay with UPI, a credit or debit card, or choose Cash on Delivery where available. Your payment details are encrypted and never stored on our systems.</p>
        </li>
        <li class="buy-step">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h11v9H3zM14 10h4l3 3v3h-7"/><circle cx="7" cy="17.5" r="1.8"/><circle cx="17" cy="17.5" r="1.8"/></svg>
          <h3>Track &amp; Receive</h3>
          <p>You'll get an order confirmation straight away and a tracking link once it ships. Follow its progress any time on <a href="track-order">Track Your Order</a>.</p>
        </li>
      </ol>
    </section>

    <!-- At a glance: payment, shipping and returns in brief, on the night band. -->
    <section class="csr-commitments buy-glance" aria-labelledby="buy-glance-title">
      <p class="about-eyebrow">Good to Know</p>
      <h2 class="about-heading" id="buy-glance-title">Before You Buy</h2>
      <ul class="csr-commitments__list">
        <li><h3>Payment Options</h3><p>UPI, Visa, Mastercard, RuPay and Cash on Delivery.</p><a href="payment-policy">Payment Policy <span aria-hidden="true">→</span></a></li>
        <li><h3>Free Shipping</h3><p>Free standard delivery on orders of ₹1,999 or more; Express from ₹250.</p><a href="shipping-policy">Shipping Policy <span aria-hidden="true">→</span></a></li>
        <li><h3>7-Day Returns</h3><p>Return or exchange unused items within 7 days of delivery.</p><a href="return-policy">Return Policy <span aria-hidden="true">→</span></a></li>
        <li><h3>Secure Checkout</h3><p>Encrypted payments through trusted, certified gateways.</p><a href="privacy-policy">Privacy Policy <span aria-hidden="true">→</span></a></li>
      </ul>
    </section>

    <!-- Tips: choosing a saree, photo beside the advice (the CSR page's initiative row). -->
    <section class="csr-initiatives buy-tips" aria-labelledby="buy-tips-title">
      <div class="csr-initiatives__head">
        <p class="about-eyebrow">Shopping Tips</p>
        <h2 class="about-heading" id="buy-tips-title">Choosing the Right Piece</h2>
      </div>
      <article class="csr-initiative">
        <div class="csr-initiative__photo"><img src="assets/pattern/brocade.png" alt="A richly woven maroon and gold brocade silk saree"></div>
        <div class="csr-initiative__text">
          <h3>Match the Fabric to the Occasion</h3>
          <ul>
            <li><strong>Weddings &amp; ceremonies:</strong> Kanjivaram, Banarasi and brocade silks with rich zari.</li>
            <li><strong>Festivals:</strong> semi silk, cotton silk and organza for colour with comfort.</li>
            <li><strong>Parties &amp; receptions:</strong> georgette, net and ready-to-wear designer sarees.</li>
            <li><strong>Everyday &amp; office:</strong> cotton, linen and lightweight printed sarees.</li>
          </ul>
          <p>Remember that colours can look slightly different on screen, and handwoven pieces have small natural variations that make each one unique.</p>
        </div>
      </article>
    </section>

    <!-- Help: the Help Center's contact cards. -->
    <section class="help-contact" aria-labelledby="buy-help-title">
      <p class="about-eyebrow">Need a Hand?</p>
      <h2 class="about-heading" id="buy-help-title">We're Happy to Help</h2>
      <div class="help-contact__grid">
        <a class="help-contact__card" href="help-center">
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M9.5 9a2.5 2.5 0 0 1 4.9.7c0 1.7-2.4 2.1-2.4 3.8M12 17h.01"/></svg>
          <span class="help-contact__name">Help Center</span>
          <span class="help-contact__detail">Answers to common questions</span>
        </a>
        <a class="help-contact__card" href="tel:800644489">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg>
          <span class="help-contact__name">Call Us</span>
          <span class="help-contact__detail">Toll Free: 800644489</span>
        </a>
        <a class="help-contact__card" href="corporate-bulk">
          <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="8" width="18" height="13" rx="1"/><path d="M12 8v13M3 12h18"/><path d="M12 8c-1.5-3-5-4-5-1.5S12 8 12 8zm0 0c1.5-3 5-4 5-1.5S12 8 12 8z"/></svg>
          <span class="help-contact__name">Buying in Bulk?</span>
          <span class="help-contact__detail">Corporate gifting &amp; bulk orders</span>
        </a>
      </div>
    </section>

  </main>
@endsection
