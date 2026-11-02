@extends('layouts.site')

@section('title', 'Mighty Silks — Career Details')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/jobs.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <p class="shop-hero__title">Career Details</p>
    </div>

    <!-- ============ Career details ============ -->
    <!-- No Figma frame for this page: built as the Careers page. js/main.js fills it from
         js/jobs.js for career-details.html?job=<slug> (no slug: the first role), lists the other
         roles and, for a slug that isn't there, says the role has closed. -->
    <section class="job" aria-labelledby="job-title" data-job-page>
      <nav class="job__crumbs" aria-label="Breadcrumb"><a href="careers.html">Careers</a><span aria-hidden="true">/</span><a href="careers.html#open-positions">Open Positions</a><span aria-hidden="true">/</span><span aria-current="page" data-job-crumb></span></nav>

      <div class="job__layout" data-job-content>
        <article class="job__main">
          <h1 class="about-heading job__title" id="job-title" data-job-title></h1>
          <ul class="job__tags" data-job-tags></ul>

          <h2 class="job__heading">About the Role</h2>
          <p class="job__text" data-job-summary></p>

          <h2 class="job__heading">Key Responsibilities</h2>
          <ul class="job__list" data-job-responsibilities></ul>

          <h2 class="job__heading">What We're Looking For</h2>
          <ul class="job__list" data-job-requirements></ul>

          <h2 class="job__heading">What We Offer</h2>
          <ul class="job__list" data-job-offer></ul>
        </article>

        <aside class="job__card" aria-labelledby="job-overview-title">
          <h2 class="job__card-title" id="job-overview-title">Job Overview</h2>
          <dl class="job__facts">
            <div><dt>Department</dt><dd data-job-department></dd></div>
            <div><dt>Location</dt><dd data-job-location></dd></div>
            <div><dt>Job type</dt><dd data-job-type></dd></div>
            <div><dt>Experience</dt><dd data-job-experience></dd></div>
          </dl>
          <button class="pdp-btn pdp-btn--solid job__apply" type="button" data-careers-apply>Apply Now</button>
          <a class="job__back" href="careers.html#open-positions">‹ Back to all openings</a>
        </aside>
      </div>

      <div class="job__missing" data-job-missing hidden>
        <h1 class="about-heading">This Role Has Closed</h1>
        <p>The position you're looking for is no longer open. Take a look at our current openings instead.</p>
        <a class="pdp-btn pdp-btn--solid about-btn" href="careers.html#open-positions">See Current Openings</a>
      </div>
    </section>

    <!-- Application form (as the Careers page; this role is chosen in it). -->
    <section class="careers-apply" id="apply" aria-labelledby="careers-apply-title" tabindex="-1" data-job-apply>
      <div class="careers-apply__intro">
        <p class="about-eyebrow">Apply</p>
        <h2 class="about-heading" id="careers-apply-title">Apply for This Role</h2>
        <p>Fill in your details and attach your CV. Our team will get back to you if your profile is a good match.</p>
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

    <!-- The other roles, as links. -->
    <section class="careers-jobs job-others" aria-labelledby="job-others-title" data-job-others-section>
      <p class="about-eyebrow">Explore More</p>
      <h2 class="about-heading" id="job-others-title">Other Openings</h2>
      <ul class="job-others__list" data-job-others></ul>
    </section>

  </main>
@endsection
