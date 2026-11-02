@extends('layouts.site')

@section('title', 'Mighty Silks — About Us')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">About Us</h1>
    </div>

    <!-- ============ About ============ -->
    <!-- No Figma frame for this page: built from the site's photos, display font and buttons. -->

    <!-- Story: text beside a portrait. -->
    <section class="about-story" aria-labelledby="about-story-title">
      <div class="about-story__text">
        <p class="about-eyebrow">Our Story</p>
        <h2 class="about-heading" id="about-story-title">Woven with Tradition, Made for Today</h2>
        <p>Mighty Silks began with a simple belief: every woman deserves to feel extraordinary in what she wears. From the looms of Kanchipuram and Banaras to the ateliers behind today's ready-to-wear designs, we bring together the finest of Indian textile craft in one place.</p>
        <p>Each saree, lehenga and gown in our collection is chosen for the quality of its weave, the richness of its colour and the care of its finish, so the pieces you wear to your most important moments are ones you'll treasure for years.</p>
        <a class="pdp-btn pdp-btn--solid about-btn" href="our-shop.html">Explore the Collection</a>
      </div>
      <div class="about-story__photo">
        <img src="assets/banners/timeless-glow.png" alt="A woman in a gold embroidered lehenga seated in a sandstone arcade">
      </div>
    </section>

    <!-- Values: four short promises with line icons. -->
    <section class="about-values" aria-labelledby="about-values-title">
      <p class="about-eyebrow">What We Stand For</p>
      <h2 class="about-heading" id="about-values-title">Crafted with Care</h2>
      <ul class="about-values__list">
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l2.6 5.3 5.9.9-4.3 4.1 1 5.8L12 16.4 6.8 19.1l1-5.8-4.3-4.1 5.9-.9z"/></svg>
          <h3>Authentic Craftsmanship</h3>
          <p>Handpicked weaves from India's great silk traditions, made by skilled artisans.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
          <h3>Curated Collections</h3>
          <p>Bridal, festive and everyday pieces, chosen season by season for every occasion.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l7 3v6c0 4.4-3 7.9-7 9-4-1.1-7-4.6-7-9V6z"/><path d="M9 12l2 2 4-4"/></svg>
          <h3>Quality Assured</h3>
          <p>Every piece is checked for weave, colour and finish before it reaches you.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/></svg>
          <h3>Customer First</h3>
          <p>Friendly styling help, secure payment and easy returns, before and after you buy.</p>
        </li>
      </ul>
    </section>

    <!-- Banner: a wide photo with a quote over a dark fade. -->
    <section class="about-banner" aria-label="Our promise">
      <img class="about-banner__photo" src="assets/banners/bride-b.png" alt="">
      <blockquote class="about-banner__quote">
        <p>“Timeless elegance, woven into every thread.”</p>
        <footer>The Mighty Silks promise</footer>
      </blockquote>
    </section>

    <!-- Collections: the home page's arch cards (Wedding collection, Figma 147:112) on a dark band. -->
    <section class="about-collections" aria-labelledby="about-collections-title">
      <p class="about-eyebrow">Discover</p>
      <h2 class="about-heading" id="about-collections-title">Our Collections</h2>
      <div class="about-collections__grid">
        <a class="arch-card" href="sarees.html">
          <span class="arch-card__media"><img src="assets/wedding/saree.png" alt=""></span>
          <span class="arch-card__title">Saree</span>
          <span class="arch-card__sub">Collections</span>
          <svg class="arch-card__trace" viewBox="0 0 417.367 621" aria-hidden="true"><path pathLength="1" d="M208.684 620.25H0.75V208.684A207.934 207.934 0 0 1 208.684 0.75A207.934 207.934 0 0 1 416.617 208.684V620.25Z"/></svg>
        </a>
        <a class="arch-card" href="gown.html">
          <span class="arch-card__media"><img src="assets/wedding/gown.png" alt=""></span>
          <span class="arch-card__title">Gown</span>
          <span class="arch-card__sub">Collections</span>
          <svg class="arch-card__trace" viewBox="0 0 417.367 621" aria-hidden="true"><path pathLength="1" d="M208.684 620.25H0.75V208.684A207.934 207.934 0 0 1 208.684 0.75A207.934 207.934 0 0 1 416.617 208.684V620.25Z"/></svg>
        </a>
        <a class="arch-card" href="lahanga.html">
          <span class="arch-card__media"><img src="assets/wedding/lehenga.png" alt=""></span>
          <span class="arch-card__title">Lahanga</span>
          <span class="arch-card__sub">Collections</span>
          <svg class="arch-card__trace" viewBox="0 0 417.367 621" aria-hidden="true"><path pathLength="1" d="M208.684 620.25H0.75V208.684A207.934 207.934 0 0 1 208.684 0.75A207.934 207.934 0 0 1 416.617 208.684V620.25Z"/></svg>
        </a>
        <a class="arch-card" href="ready-to-wear.html">
          <span class="arch-card__media"><img src="assets/wedding/ready-to-wear.png" alt=""></span>
          <span class="arch-card__title">Ready To Wear</span>
          <span class="arch-card__sub">Collections</span>
          <svg class="arch-card__trace" viewBox="0 0 417.367 621" aria-hidden="true"><path pathLength="1" d="M208.684 620.25H0.75V208.684A207.934 207.934 0 0 1 208.684 0.75A207.934 207.934 0 0 1 416.617 208.684V620.25Z"/></svg>
        </a>
      </div>
    </section>

    <!-- Visit: the footer's address and contacts, with a shop link. -->
    <section class="about-visit" aria-labelledby="about-visit-title">
      <div>
        <p class="about-eyebrow">Visit Us</p>
        <h2 class="about-heading" id="about-visit-title">We'd Love to See You</h2>
        <p class="about-visit__lead">Drop by our office, call us or write to us. We're happy to help you find the perfect piece.</p>
      </div>
      <dl class="about-visit__details">
        <div><dt>Address</dt><dd>Office #816 - 8th Floor, The Burlington Tower,<br>Marasi Drive, Business Bay, Dubai, UAE</dd></div>
        <div><dt>Phone</dt><dd>Toll Free: 800644489<br>+971 54 586 4310 | +971 54 586 4309</dd></div>
        <div><dt>Email</dt><dd><a href="mailto:info@mightysilks.ae">info@mightysilks.ae</a></dd></div>
      </dl>
    </section>

  </main>
@endsection
