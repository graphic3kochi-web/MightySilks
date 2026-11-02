@extends('layouts.site')

@section('title', 'Mighty Silks — Careers')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Careers</h1>
    </div>

    <!-- ============ Careers ============ -->
    <!-- No Figma frame for this page: built as the About page (its sections, fonts and cards).
         js/main.js opens a role's Apply Now on the form with that role chosen, checks the form and
         shows a thank-you (there's no backend, so nothing is sent). -->

    <!-- Intro: text beside a photo. -->
    <section class="about-story" aria-labelledby="careers-intro-title">
      <div class="about-story__text">
        <p class="about-eyebrow">Join Our Team</p>
        <h2 class="about-heading" id="careers-intro-title">Build a Career Woven in Style</h2>
        <p>At Mighty Silks, we're passionate about bringing the beauty of Indian craftsmanship to every customer. We're always looking for people who share that passion, whether you love fashion, people, design or the details that make a great experience.</p>
        <p>Grow with a team that values creativity, care and a genuine love for what we do.</p>
        <a class="pdp-btn pdp-btn--solid about-btn" href="#open-positions">View Open Positions</a>
      </div>
      <div class="about-story__photo about-story__photo--wide">
        <img src="assets/banners/timeless-1.png" alt="Two women in embroidered lehengas in a sandstone arcade">
      </div>
    </section>

    <!-- Why join: four short reasons (the About page's value cards). -->
    <section class="about-values" aria-labelledby="careers-why-title">
      <p class="about-eyebrow">Why Work With Us</p>
      <h2 class="about-heading" id="careers-why-title">Life at Mighty Silks</h2>
      <ul class="about-values__list">
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/></svg>
          <h3>Grow With Us</h3>
          <p>Training, mentoring and room to take on more as you learn.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.2"/><path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/><circle cx="17.5" cy="9" r="2.5"/><path d="M16 14.2c3 .2 5 2.6 5 5.8"/></svg>
          <h3>A Supportive Team</h3>
          <p>Friendly colleagues who share ideas and celebrate each other's wins.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l2.6 5.3 5.9.9-4.3 4.1 1 5.8L12 16.4 6.8 19.1l1-5.8-4.3-4.1 5.9-.9z"/></svg>
          <h3>Work With Beautiful Things</h3>
          <p>Spend your days around fine silks, bridal wear and new collections.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="8" width="18" height="13" rx="1"/><path d="M12 8v13M3 12h18"/><path d="M12 8c-1.5-3-5-4-5-1.5S12 8 12 8zm0 0c1.5-3 5-4 5-1.5S12 8 12 8z"/></svg>
          <h3>Staff Benefits</h3>
          <p>Employee discounts on our collections and recognition for great work.</p>
        </li>
      </ul>
    </section>

    <!-- Open positions: each role opens to its details and an Apply Now button. -->
    <section class="careers-jobs" id="open-positions" aria-labelledby="careers-jobs-title">
      <p class="about-eyebrow">Open Positions</p>
      <h2 class="about-heading" id="careers-jobs-title">Current Openings</h2>
      <div class="careers-jobs__list">
        <details class="careers-job">
          <summary><span class="careers-job__title">Fashion Sales Associate</span><span class="careers-job__meta">Dubai · Full-time</span></summary>
          <div class="careers-job__body">
            <p>Help customers find the perfect saree, lehenga or gown, share styling advice and keep the store looking its best.</p>
            <ul><li>Experience in fashion or luxury retail preferred</li><li>Warm, confident communication in English; Hindi, Malayalam or Arabic a plus</li><li>Flexible to work weekends and festive seasons</li></ul>
            <div class="careers-job__actions">
              <button class="pdp-btn pdp-btn--solid careers-job__apply" type="button" data-careers-apply="Fashion Sales Associate">Apply Now</button>
              <a class="pdp-btn pdp-btn--outline careers-job__apply" href="career-details.html?job=fashion-sales-associate">View Details</a>
            </div>
          </div>
        </details>
        <details class="careers-job">
          <summary><span class="careers-job__title">Visual Merchandiser</span><span class="careers-job__meta">Dubai · Full-time</span></summary>
          <div class="careers-job__body">
            <p>Bring our collections to life through window displays, in-store styling and seasonal campaigns.</p>
            <ul><li>A strong eye for colour, texture and composition</li><li>Experience in fashion visual merchandising</li><li>A portfolio of past displays</li></ul>
            <div class="careers-job__actions">
              <button class="pdp-btn pdp-btn--solid careers-job__apply" type="button" data-careers-apply="Visual Merchandiser">Apply Now</button>
              <a class="pdp-btn pdp-btn--outline careers-job__apply" href="career-details.html?job=visual-merchandiser">View Details</a>
            </div>
          </div>
        </details>
        <details class="careers-job">
          <summary><span class="careers-job__title">Customer Care Executive</span><span class="careers-job__meta">Dubai · Full-time</span></summary>
          <div class="careers-job__body">
            <p>Be the friendly voice of Mighty Silks: answer questions, track orders and make returns easy by phone, email and chat.</p>
            <ul><li>Customer service experience, ideally in e-commerce</li><li>Clear written and spoken English</li><li>Calm, patient and organised</li></ul>
            <div class="careers-job__actions">
              <button class="pdp-btn pdp-btn--solid careers-job__apply" type="button" data-careers-apply="Customer Care Executive">Apply Now</button>
              <a class="pdp-btn pdp-btn--outline careers-job__apply" href="career-details.html?job=customer-care-executive">View Details</a>
            </div>
          </div>
        </details>
        <details class="careers-job">
          <summary><span class="careers-job__title">Social Media &amp; Content Executive</span><span class="careers-job__meta">Dubai · Full-time</span></summary>
          <div class="careers-job__body">
            <p>Plan and create content for our social channels, photo shoots and new collection launches.</p>
            <ul><li>Experience running fashion or lifestyle social accounts</li><li>Photography, video or design skills</li><li>Up to date with trends across Instagram, Pinterest and YouTube</li></ul>
            <div class="careers-job__actions">
              <button class="pdp-btn pdp-btn--solid careers-job__apply" type="button" data-careers-apply="Social Media &amp; Content Executive">Apply Now</button>
              <a class="pdp-btn pdp-btn--outline careers-job__apply" href="career-details.html?job=social-media-content-executive">View Details</a>
            </div>
          </div>
        </details>
      </div>
      <p class="careers-jobs__note">Don't see the right role? Send us your CV anyway. We'd love to hear from you.</p>
    </section>

    <!-- Application form (the checkout's fields). -->
    <section class="careers-apply" id="apply" aria-labelledby="careers-apply-title" tabindex="-1">
      <div class="careers-apply__intro">
        <p class="about-eyebrow">Apply</p>
        <h2 class="about-heading" id="careers-apply-title">Send Your Application</h2>
        <p>Fill in your details and attach your CV. Our team will get back to you if your profile matches a current or upcoming role.</p>
      </div>
      <form class="careers-apply__form" data-careers-form novalidate>
        <div class="checkout__grid">
          <label class="checkout-field"><span>Full name</span><input type="text" name="name" required autocomplete="name"></label>
          <label class="checkout-field"><span>Email</span><input type="email" name="email" required autocomplete="email"></label>
          <label class="checkout-field"><span>Phone</span><input type="tel" name="phone" required autocomplete="tel" pattern="[0-9+ ()-]{7,}"></label>
          <label class="checkout-field"><span>Position</span>
            <select name="position" required data-careers-position>
              <option value="">Select a position</option>
              <option>Fashion Sales Associate</option>
              <option>Visual Merchandiser</option>
              <option>Customer Care Executive</option>
              <option>Social Media &amp; Content Executive</option>
              <option>Other / General application</option>
            </select>
          </label>
          <label class="checkout-field checkout-field--full"><span>CV / Resume (PDF or Word, up to 5 MB)</span><input class="careers-apply__file" type="file" name="cv" required accept=".pdf,.doc,.docx"></label>
          <label class="checkout-field checkout-field--full"><span>Tell us about yourself (optional)</span><textarea name="message" rows="5"></textarea></label>
        </div>
        <p class="login__status" role="alert" data-careers-status></p>
        <button class="pdp-btn pdp-btn--solid careers-apply__submit" type="submit">Submit Application</button>
      </form>
    </section>

  </main>
@endsection
