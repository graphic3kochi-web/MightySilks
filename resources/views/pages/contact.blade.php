@extends('layouts.site')

@section('title', 'Mighty Silks — Contact Us')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Contact Us</h1>
    </div>

    <!-- ============ Contact ============ -->
    <!-- No Figma frame for this page: the Help Center's contact cards, the careers application
         form's layout and a map. js/main.js checks the form, sends it to the store (Admin ›
         Enquiries) and opens the thank-you page. -->

    <!-- Ways to reach us: the Help Center's three cards. -->
    <section class="contact-ways" aria-labelledby="contact-ways-title">
      <p class="about-eyebrow">Get in Touch</p>
      <h2 class="about-heading" id="contact-ways-title">We're Here to Help</h2>
      <p class="contact-ways__lead">Questions about an order, a saree you've had your eye on or a special occasion? Reach us whichever way suits you.</p>
      <div class="help-contact__grid">
        <a class="help-contact__card" href="tel:800644489">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg>
          <span class="help-contact__name">Call Us</span>
          <span class="help-contact__detail">Toll Free: 800644489</span>
          <span class="help-contact__detail">+971 54 586 4310 | +971 54 586 4309</span>
        </a>
        <a class="help-contact__card" href="mailto:info@mightysilks.ae">
          <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
          <span class="help-contact__name">Email Us</span>
          <span class="help-contact__detail">info@mightysilks.ae</span>
          <span class="help-contact__detail">Include your order number if you have one</span>
        </a>
        <a class="help-contact__card" href="https://www.google.com/maps/search/?api=1&amp;query=The+Burlington+Tower+Business+Bay+Dubai" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7-6.2-7-12a7 7 0 0 1 14 0c0 5.8-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>
          <span class="help-contact__name">Visit Us</span>
          <span class="help-contact__detail">Office #816, The Burlington Tower</span>
          <span class="help-contact__detail">Marasi Drive, Business Bay, Dubai</span>
        </a>
      </div>
    </section>

    <!-- Message form (the careers application form's layout). -->
    <section class="careers-apply" id="message" aria-labelledby="contact-form-title" tabindex="-1">
      <div class="careers-apply__intro">
        <p class="about-eyebrow">Send a Message</p>
        <h2 class="about-heading" id="contact-form-title">Write to Us</h2>
        <p>Fill in the form and our team will get back to you as soon as possible.</p>
        <p>Looking for a quick answer? Our <a href="help-center.html">Help Center</a> covers orders, shipping and returns, and you can follow a parcel on <a href="track-order.html">Track Order</a>. For gifting in quantity, see <a href="corporate-bulk.html">Corporate &amp; Bulk</a>.</p>
      </div>
      <form class="careers-apply__form" data-contact-form novalidate>
        <div class="checkout__grid">
          <label class="checkout-field"><span>Full name</span><input type="text" name="name" required autocomplete="name"></label>
          <label class="checkout-field"><span>Email</span><input type="email" name="email" required autocomplete="email"></label>
          <label class="checkout-field"><span>Phone (optional)</span><input type="tel" name="phone" autocomplete="tel" pattern="[0-9+ ()-]{7,}"></label>
          <label class="checkout-field"><span>Order number (optional)</span><input type="text" name="order" maxlength="32" placeholder="e.g. MS-1042"></label>
          <label class="checkout-field checkout-field--full"><span>What's it about?</span>
            <select name="subject" required>
              <option value="">Select a topic</option>
              <option>An existing order</option>
              <option>Returns &amp; exchanges</option>
              <option>A product question</option>
              <option>Payments</option>
              <option>Feedback</option>
              <option>Something else</option>
            </select>
          </label>
          <label class="checkout-field checkout-field--full"><span>Message</span><textarea name="message" rows="6" required placeholder="How can we help?"></textarea></label>
        </div>
        <p class="login__status" role="alert" data-contact-status></p>
        <button class="pdp-btn pdp-btn--solid careers-apply__submit" type="submit">Send Message</button>
      </form>
    </section>

    <!-- Map: the office, loaded only when scrolled near. -->
    <section class="contact-map" aria-label="Map to our office">
      <iframe title="Mighty Silks office on Google Maps" src="https://maps.google.com/maps?q=The%20Burlington%20Tower%2C%20Business%20Bay%2C%20Dubai&amp;z=16&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

  </main>
@endsection
