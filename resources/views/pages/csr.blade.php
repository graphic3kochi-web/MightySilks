@extends('layouts.site')

@section('title', 'Mighty Silks — CSR')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Corporate Social Responsibility</h1>
    </div>

    <!-- ============ CSR ============ -->
    <!-- No Figma frame for this page: built as the About page (its sections, fonts and cards). -->

    <!-- Intro: text beside a portrait. -->
    <section class="about-story" aria-labelledby="csr-intro-title">
      <div class="about-story__text">
        <p class="about-eyebrow">Our Responsibility</p>
        <h2 class="about-heading" id="csr-intro-title">Weaving a Better Tomorrow</h2>
        <p>Every saree tells the story of the hands that made it. At Mighty Silks, we believe beautiful clothing should also do good: for the weavers and artisans behind it, for the communities we serve and for the planet we share.</p>
        <p>Our CSR commitments guide how we source, how we work and how we give back, so that the tradition of Indian textiles can thrive for generations to come.</p>
        <a class="pdp-btn pdp-btn--solid about-btn" href="#csr-initiatives">See Our Initiatives</a>
      </div>
      <div class="about-story__photo">
        <img src="assets/pattern/zari-woven.png" alt="A peach silk saree with fine gold zari weaving draped over a wooden chair">
      </div>
    </section>

    <!-- Focus areas: four cards (the About page's value cards). -->
    <section class="about-values" aria-labelledby="csr-focus-title">
      <p class="about-eyebrow">Where We Focus</p>
      <h2 class="about-heading" id="csr-focus-title">Our Focus Areas</h2>
      <ul class="about-values__list">
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h16v16H4z"/><path d="M4 9h16M4 14h16M9 4v16M14 4v16"/></svg>
          <h3>Artisans &amp; Weavers</h3>
          <p>Supporting the craftspeople who keep India's handloom traditions alive.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M12 12v9M9 18h6"/></svg>
          <h3>Women Empowerment</h3>
          <p>Creating skills, jobs and opportunities for women in our community.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 19c0-8 6-14 15-14 0 9-6 15-14 15"/><path d="M5 19l7-7"/></svg>
          <h3>Sustainable Practices</h3>
          <p>Responsible sourcing, less waste and greener packaging choices.</p>
        </li>
        <li class="about-value">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/></svg>
          <h3>Community Care</h3>
          <p>Giving back through education, health and festive outreach.</p>
        </li>
      </ul>
    </section>

    <!-- Initiatives: photo and text rows, alternating sides. -->
    <section class="csr-initiatives" id="csr-initiatives" aria-labelledby="csr-initiatives-title">
      <div class="csr-initiatives__head">
        <p class="about-eyebrow">What We Do</p>
        <h2 class="about-heading" id="csr-initiatives-title">Our Initiatives</h2>
      </div>

      <article class="csr-initiative">
        <div class="csr-initiative__photo"><img src="assets/pattern/brocade.png" alt="A richly woven brocade silk saree"></div>
        <div class="csr-initiative__text">
          <span class="csr-initiative__num">01</span>
          <h3>Empowering Handloom Weavers</h3>
          <p>Handloom weaving is an art passed down through generations. We work with weaving clusters and artisans to bring their craft to new customers, helping traditional skills stay valued and sustainable.</p>
          <ul>
            <li>Fair and timely payment for artisans and suppliers</li>
            <li>Long-term partnerships with weaving communities</li>
            <li>Telling the stories of the makers behind our collections</li>
          </ul>
        </div>
      </article>

      <article class="csr-initiative csr-initiative--reverse">
        <div class="csr-initiative__photo"><img src="assets/pattern/feature.png" alt="Three women in printed sarees sharing tea and laughing"></div>
        <div class="csr-initiative__text">
          <span class="csr-initiative__num">02</span>
          <h3>Women at the Heart of Our Work</h3>
          <p>Our brand is built for women, and by many talented women. We are committed to creating an inclusive workplace and supporting women to build skills, confidence and independent livelihoods.</p>
          <ul>
            <li>Training in retail, styling, tailoring and customer care</li>
            <li>Flexible opportunities for women returning to work</li>
            <li>Mentoring and growth paths within our team</li>
          </ul>
        </div>
      </article>

      <article class="csr-initiative">
        <div class="csr-initiative__photo"><img src="assets/pattern/check.png" alt="A folded navy and gold silk saree beside jasmine flowers and green leaves"></div>
        <div class="csr-initiative__text">
          <span class="csr-initiative__num">03</span>
          <h3>Greener Choices</h3>
          <p>Fashion should be made to last. We encourage timeless pieces that are worn and loved for years, and we keep looking for ways to reduce our impact across sourcing, packaging and delivery.</p>
          <ul>
            <li>Moving towards recyclable and reusable packaging</li>
            <li>Reducing fabric waste and reusing offcuts</li>
            <li>Choosing natural and eco-friendly fabrics where possible</li>
          </ul>
        </div>
      </article>
    </section>

    <!-- Commitments: four promises on the night band. -->
    <section class="csr-commitments" aria-labelledby="csr-commitments-title">
      <p class="about-eyebrow">Our Promise</p>
      <h2 class="about-heading" id="csr-commitments-title">Our Commitments</h2>
      <ol class="csr-commitments__list">
        <li><h3>Ethical Sourcing</h3><p>Working with suppliers who treat their people fairly and safely.</p></li>
        <li><h3>Celebrating Craft</h3><p>Protecting and promoting India's textile heritage.</p></li>
        <li><h3>Caring for the Planet</h3><p>Steadily reducing waste across our operations.</p></li>
        <li><h3>Giving Back</h3><p>Supporting local causes in the communities we serve.</p></li>
      </ol>
    </section>

    <!-- Partner: contact for CSR collaborations. -->
    <section class="about-visit csr-partner" aria-labelledby="csr-partner-title">
      <div>
        <p class="about-eyebrow">Get Involved</p>
        <h2 class="about-heading" id="csr-partner-title">Partner With Us</h2>
        <p class="about-visit__lead">Are you an NGO, weaving cooperative or organisation working for artisans, women or the environment? We'd love to hear from you and explore how we can make a difference together.</p>
      </div>
      <div class="csr-partner__actions">
        <a class="pdp-btn pdp-btn--solid about-btn" href="mailto:info@mightysilks.ae?subject=CSR%20Partnership">Get in Touch</a>
        <a class="pdp-btn pdp-btn--outline about-btn" href="our-shop">Shop Consciously</a>
      </div>
    </section>

  </main>
@endsection
