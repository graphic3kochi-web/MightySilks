@extends('layouts.site')

@section('title', 'Mighty Silks — Corporate & Bulk Orders')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Corporate &amp; Bulk Orders</h1>
    </div>

    <!-- ============ Corporate & bulk ============ -->
    <!-- No Figma frame for this page: the About page's sections, the CSR page's numbered band, the
         careers FAQ rows and application form. js/main.js checks the enquiry form and thanks the
         sender (no backend: nothing is sent). -->

    <!-- Intro: text beside a photo. -->
    <section class="about-story" aria-labelledby="bulk-intro-title">
      <div class="about-story__text">
        <p class="about-eyebrow">Corporate Gifting &amp; Bulk Orders</p>
        <h2 class="about-heading" id="bulk-intro-title">Gifts That Leave a Lasting Impression</h2>
        <p>From festive gifts for your team to coordinated sarees for a wedding party, Mighty Silks makes ordering in quantity simple. Choose from our sarees, lehengas and ready-to-wear collections, or let us curate a selection for your occasion and budget.</p>
        <p>Our team handles everything from selection and packaging to delivery, so you can focus on the celebration.</p>
        <a class="pdp-btn pdp-btn--solid about-btn" href="#enquiry">Request a Quote</a>
      </div>
      <div class="about-story__photo">
        <img src="assets/occasion/diwali.png" alt="Two women in festive sarees holding a sparkler and a stack of wrapped gifts">
      </div>
    </section>

    <!-- Who it's for: four cards (the About page's value cards). -->
    <section class="about-values" aria-labelledby="bulk-for-title">
      <p class="about-eyebrow">Perfect For</p>
      <h2 class="about-heading" id="bulk-for-title">Every Occasion, Any Scale</h2>
      <ul class="about-values__list">
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="8" width="18" height="13" rx="1"/><path d="M12 8v13M3 12h18"/><path d="M12 8c-1.5-3-5-4-5-1.5S12 8 12 8zm0 0c1.5-3 5-4 5-1.5S12 8 12 8z"/></svg>
          <h3>Corporate Gifting</h3>
          <p>Festive gifts for employees, clients and partners for Diwali, Onam, Eid and more.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/></svg>
          <h3>Weddings &amp; Families</h3>
          <p>Coordinated sarees and lehengas for bridesmaids, family members and return gifts.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.2"/><path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/><circle cx="17.5" cy="9" r="2.5"/><path d="M16 14.2c3 .2 5 2.6 5 5.8"/></svg>
          <h3>Events &amp; Uniforms</h3>
          <p>Matching sarees for staff, hospitality teams, cultural programmes and celebrations.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 9l1.5-5h15L21 9M3 9h18v11H3zM9 20v-6h6v6"/></svg>
          <h3>Retailers &amp; Boutiques</h3>
          <p>Wholesale enquiries for stores looking to stock handpicked silk collections.</p>
        </li>
      </ul>
    </section>

    <!-- How it works: four numbered steps on the night band (the CSR page's commitments). -->
    <section class="csr-commitments" aria-labelledby="bulk-steps-title">
      <p class="about-eyebrow">Simple Process</p>
      <h2 class="about-heading" id="bulk-steps-title">How It Works</h2>
      <ol class="csr-commitments__list">
        <li><h3>Share Your Needs</h3><p>Tell us the occasion, quantity, budget and timeline using the form below.</p></li>
        <li><h3>Get a Curated Quote</h3><p>Our team suggests products and sends you a quote with pricing.</p></li>
        <li><h3>Approve &amp; Personalise</h3><p>Confirm your selection and add gift wrapping or a personal message.</p></li>
        <li><h3>We Deliver</h3><p>Your order is packed with care and delivered to one or many addresses.</p></li>
      </ol>
    </section>

    <!-- Benefits: what bulk buyers get. -->
    <section class="about-values bulk-benefits" aria-labelledby="bulk-benefits-title">
      <p class="about-eyebrow">Why Order With Us</p>
      <h2 class="about-heading" id="bulk-benefits-title">The Mighty Silks Advantage</h2>
      <ul class="about-values__list">
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 12l-8 8-9-9V3h8z"/><circle cx="7.5" cy="7.5" r="1.5"/></svg>
          <h3>Special Bulk Pricing</h3>
          <p>Volume-based pricing tailored to the size of your order.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg>
          <h3>Dedicated Support</h3>
          <p>One point of contact from your first enquiry to final delivery.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="8" width="18" height="13" rx="1"/><path d="M12 8v13M3 12h18"/></svg>
          <h3>Gift Packaging</h3>
          <p>Elegant gift boxes, wrapping and personalised message cards.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h11v9H3zM14 10h4l3 3v3h-7"/><circle cx="7" cy="17.5" r="1.8"/><circle cx="17" cy="17.5" r="1.8"/></svg>
          <h3>Multi-Address Delivery</h3>
          <p>Ship to one office or straight to each recipient.</p>
        </li>
      </ul>
    </section>

    <!-- Enquiry form (the careers application form's layout). -->
    <section class="careers-apply" id="enquiry" aria-labelledby="bulk-enquiry-title" tabindex="-1">
      <div class="careers-apply__intro">
        <p class="about-eyebrow">Get a Quote</p>
        <h2 class="about-heading" id="bulk-enquiry-title">Send Us Your Enquiry</h2>
        <p>Share a few details and our corporate team will get back to you with suggestions and a quote.</p>
        <p>Prefer to talk? Call us toll free on <a href="tel:800644489">800644489</a> or email <a href="mailto:info@mightysilks.ae?subject=Corporate%20%26%20Bulk%20Enquiry">info@mightysilks.ae</a>.</p>
      </div>
      <form class="careers-apply__form" data-bulk-form novalidate>
        <div class="checkout__grid">
          <label class="checkout-field"><span>Full name</span><input type="text" name="name" required autocomplete="name"></label>
          <label class="checkout-field"><span>Company / Organisation (optional)</span><input type="text" name="company" autocomplete="organization"></label>
          <label class="checkout-field"><span>Email</span><input type="email" name="email" required autocomplete="email"></label>
          <label class="checkout-field"><span>Phone</span><input type="tel" name="phone" required autocomplete="tel" pattern="[0-9+ ()-]{7,}"></label>
          <label class="checkout-field"><span>Type of order</span>
            <select name="type" required>
              <option value="">Select an option</option>
              <option>Corporate gifting</option>
              <option>Wedding / family order</option>
              <option>Event or uniform order</option>
              <option>Wholesale / retail</option>
              <option>Other</option>
            </select>
          </label>
          <label class="checkout-field"><span>Approximate quantity</span><input type="number" name="quantity" required min="10" step="1" inputmode="numeric" placeholder="Minimum 10 pieces"></label>
          <label class="checkout-field"><span>Budget per piece (optional)</span><input type="text" name="budget" placeholder="e.g. ₹3,000 – ₹5,000"></label>
          <label class="checkout-field"><span>Required by (optional)</span><input type="date" name="date"></label>
          <label class="checkout-field checkout-field--full"><span>Tell us about your requirements</span><textarea name="message" rows="5" placeholder="Occasion, preferred colours or fabrics, packaging, delivery locations…"></textarea></label>
        </div>
        <p class="login__status" role="alert" data-bulk-status></p>
        <button class="pdp-btn pdp-btn--solid careers-apply__submit" type="submit">Send Enquiry</button>
      </form>
    </section>

    <!-- FAQs (the careers page's open/close rows). -->
    <section class="careers-jobs" aria-labelledby="bulk-faq-title">
      <p class="about-eyebrow">Questions</p>
      <h2 class="about-heading" id="bulk-faq-title">Frequently Asked Questions</h2>
      <div class="careers-jobs__list">
        <details class="careers-job help-faq"><summary><span class="careers-job__title">What is the minimum order quantity?</span></summary><div class="careers-job__body"><p>Bulk and corporate orders start from <strong>10 pieces</strong>. For smaller quantities, you're welcome to order directly from our <a href="our-shop">shop</a>.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Can I mix different products in one order?</span></summary><div class="careers-job__body"><p>Yes. You can combine sarees, lehengas and ready-to-wear pieces in different colours and designs within one bulk order, subject to availability.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">How long does a bulk order take?</span></summary><div class="careers-job__body"><p>It depends on the quantity and availability of the products you choose. We'll confirm the timeline with your quote, so please contact us as early as possible for festive or wedding dates.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Do you offer gift wrapping and personalisation?</span></summary><div class="careers-job__body"><p>Yes. We can provide gift boxes, wrapping and personalised message cards. Let us know your requirements in the enquiry form.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">How do payment and invoicing work?</span></summary><div class="careers-job__body"><p>Payment terms are agreed with your quote. We provide a proper invoice for every corporate order. See our <a href="payment-policy">Payment Policy</a> for accepted payment methods.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Can you deliver to multiple addresses?</span></summary><div class="careers-job__body"><p>Yes. We can ship your order to a single location or directly to each recipient. Share the delivery details with us and we'll include shipping in your quote.</p></div></details>
      </div>
    </section>

  </main>
@endsection
