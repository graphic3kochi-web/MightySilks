@extends('layouts.site')

@section('title', 'Mighty Silks — Blogs')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Our Blogs</h1>
    </div>

    <!-- ============ Blog ============ -->
    <!-- No Figma frame for this page: the home page's blog cards (Figma 171:1955) as a page.
         js/main.js filters the grid by the category chips. -->

    <!-- Featured post: wide photo beside its intro. -->
    <section class="blog-feature" aria-labelledby="blog-feature-title">
      <a class="blog-feature__media" href="blog-details.html?post=bridal-kanchipuram-saree-trends-2026" tabindex="-1" aria-hidden="true"><img src="assets/blogs/blog-1.png" alt=""></a>
      <div class="blog-feature__text">
        <p class="about-eyebrow">Featured Story</p>
        <span class="blog-card__tag">Bridal Kanchipuram Saree</span>
        <h2 class="blog-feature__title" id="blog-feature-title"><a href="blog-details.html?post=bridal-kanchipuram-saree-trends-2026">Bridal Kanchipuram Saree Trends 2026: Pastel Shades, Lightweight Weaves &amp; Minimal Zari</a></h2>
        <p class="blog-post__meta"><time datetime="2026-10-20">20 Oct 2026</time> · 6 min read</p>
        <p class="blog-feature__excerpt">Brides are moving beyond classic reds and golds. From soft peach and mint to lightweight silks and delicate zari, here are the Kanchipuram trends shaping weddings this season, and how to choose the one that's right for you.</p>
        <a class="pdp-btn pdp-btn--solid about-btn" href="blog-details.html?post=bridal-kanchipuram-saree-trends-2026">Read Article</a>
      </div>
    </section>

    <!-- Latest posts: category chips over a grid of cards. -->
    <section class="blog-latest" aria-labelledby="blog-latest-title">
      <div class="blog-latest__head">
        <div>
          <p class="about-eyebrow">Latest Stories</p>
          <h2 class="about-heading" id="blog-latest-title">Style Notes &amp; Traditions</h2>
        </div>
        <div class="blog-filters" role="group" aria-label="Filter posts by category" data-blog-filters>
          <button class="blog-filter" type="button" aria-pressed="true" data-blog-filter="all">All</button>
          <button class="blog-filter" type="button" aria-pressed="false" data-blog-filter="bridal">Bridal</button>
          <button class="blog-filter" type="button" aria-pressed="false" data-blog-filter="festive">Festive</button>
          <button class="blog-filter" type="button" aria-pressed="false" data-blog-filter="style-guide">Style Guide</button>
        </div>
      </div>

      <div class="blog-list" data-blog-list>
        <article class="blog-post" data-category="bridal">
          <a class="blog-post__media" href="blog-details.html?post=bridal-kanchipuram-saree-trends-2026" tabindex="-1" aria-hidden="true"><img src="assets/blogs/blog-1.png" alt=""></a>
          <span class="blog-card__tag">Bridal Kanchipuram Saree</span>
          <p class="blog-post__meta"><time datetime="2026-10-20">20 Oct 2026</time> · 6 min read</p>
          <h3 class="blog-post__title"><a href="blog-details.html?post=bridal-kanchipuram-saree-trends-2026">Bridal Kanchipuram Saree Trends 2026: Pastel Shades, Lightweight Weaves &amp; Minimal Zari</a></h3>
          <p class="blog-post__excerpt">Soft pastels, lighter silks and minimal zari: the Kanchipuram trends brides love this season.</p>
          <a class="blog-post__more" href="blog-details.html?post=bridal-kanchipuram-saree-trends-2026">Read More <span aria-hidden="true">→</span></a>
        </article>
        <article class="blog-post" data-category="bridal">
          <a class="blog-post__media" href="blog-details.html?post=manthrakodi-saree-styles-christian-brides" tabindex="-1" aria-hidden="true"><img src="assets/blogs/blog-2.png" alt=""></a>
          <span class="blog-card__tag">Manthrakodi Saree</span>
          <p class="blog-post__meta"><time datetime="2026-10-12">12 Oct 2026</time> · 5 min read</p>
          <h3 class="blog-post__title"><a href="blog-details.html?post=manthrakodi-saree-styles-christian-brides">Traditional and Modern Manthrakodi Saree Styles for Christian Brides</a></h3>
          <p class="blog-post__excerpt">From classic cream and gold to contemporary pastels, find the Manthrakodi that suits your big day.</p>
          <a class="blog-post__more" href="blog-details.html?post=manthrakodi-saree-styles-christian-brides">Read More <span aria-hidden="true">→</span></a>
        </article>
        <article class="blog-post" data-category="festive">
          <a class="blog-post__media" href="blog-details.html?post=best-onam-churidar-designs" tabindex="-1" aria-hidden="true"><img src="assets/blogs/blog-3.png" alt=""></a>
          <span class="blog-card__tag">Onam Churidar</span>
          <p class="blog-post__meta"><time datetime="2026-09-28">28 Sep 2026</time> · 4 min read</p>
          <h3 class="blog-post__title"><a href="blog-details.html?post=best-onam-churidar-designs">10 Best Onam Churidar Designs to Shop This Festive Season</a></h3>
          <p class="blog-post__excerpt">Kasavu borders, temple motifs and fresh colours: our pick of churidars for Onam celebrations.</p>
          <a class="blog-post__more" href="blog-details.html?post=best-onam-churidar-designs">Read More <span aria-hidden="true">→</span></a>
        </article>
        <article class="blog-post" data-category="style-guide">
          <a class="blog-post__media" href="blog-details.html?post=traditional-vs-modern-dhavani-designs" tabindex="-1" aria-hidden="true"><img src="assets/blogs/blog-4.png" alt=""></a>
          <span class="blog-card__tag">Dhavani Designs</span>
          <p class="blog-post__meta"><time datetime="2026-09-15">15 Sep 2026</time> · 5 min read</p>
          <h3 class="blog-post__title"><a href="blog-details.html?post=traditional-vs-modern-dhavani-designs">Traditional vs Modern Dhavani Designs: Which Style Is Right for You?</a></h3>
          <p class="blog-post__excerpt">A simple guide to choosing between heritage silk dhavanis and their lighter, modern cousins.</p>
          <a class="blog-post__more" href="blog-details.html?post=traditional-vs-modern-dhavani-designs">Read More <span aria-hidden="true">→</span></a>
        </article>
        <article class="blog-post" data-category="festive">
          <a class="blog-post__media" href="blog-details.html?post=puliyilakkara-set-mundu-onam" tabindex="-1" aria-hidden="true"><img src="assets/blogs/blog-5.png" alt=""></a>
          <span class="blog-card__tag">Puliyilakkara Set Mundu</span>
          <p class="blog-post__meta"><time datetime="2026-09-02">2 Sep 2026</time> · 4 min read</p>
          <h3 class="blog-post__title"><a href="blog-details.html?post=puliyilakkara-set-mundu-onam">Why Wearing a Puliyilakkara Set Mundu During Onam Is a Celebration of Kerala Identity</a></h3>
          <p class="blog-post__excerpt">The story behind the Puliyilakkara border and why it remains at the heart of Onam.</p>
          <a class="blog-post__more" href="blog-details.html?post=puliyilakkara-set-mundu-onam">Read More <span aria-hidden="true">→</span></a>
        </article>
        <article class="blog-post" data-category="style-guide festive">
          <a class="blog-post__media" href="blog-details.html?post=onam-churidar-designs-college-girls" tabindex="-1" aria-hidden="true"><img src="assets/blogs/blog-6.png" alt=""></a>
          <span class="blog-card__tag">Onam Churidar</span>
          <p class="blog-post__meta"><time datetime="2026-08-25">25 Aug 2026</time> · 3 min read</p>
          <h3 class="blog-post__title"><a href="blog-details.html?post=onam-churidar-designs-college-girls">Best Onam Churidar Designs for College Girls and Young Women</a></h3>
          <p class="blog-post__excerpt">Easy, comfortable and festive: churidar ideas for campus celebrations and Onam days out.</p>
          <a class="blog-post__more" href="blog-details.html?post=onam-churidar-designs-college-girls">Read More <span aria-hidden="true">→</span></a>
        </article>
      </div>
      <p class="blog-list__empty" data-blog-empty hidden>No stories in this category yet.</p>
    </section>

    <!-- Newsletter: email sign-up on the night band. -->
    <section class="blog-newsletter" aria-labelledby="blog-newsletter-title">
      <p class="about-eyebrow">Stay in Style</p>
      <h2 class="about-heading" id="blog-newsletter-title">Get New Stories in Your Inbox</h2>
      <p class="blog-newsletter__lead">Styling tips, festive guides and first looks at new collections, once or twice a month.</p>
      <form class="blog-newsletter__form" data-newsletter-form novalidate>
        <label class="visually-hidden" for="newsletter-email">Email address</label>
        <input id="newsletter-email" type="email" name="email" required autocomplete="email" placeholder="Your email address">
        <button class="pdp-btn" type="submit">Subscribe</button>
      </form>
      <p class="blog-newsletter__status" role="status" data-newsletter-status></p>
    </section>

  </main>
@endsection
