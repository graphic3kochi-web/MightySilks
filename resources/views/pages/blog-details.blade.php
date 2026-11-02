@extends('layouts.site')

@section('title', 'Mighty Silks — Blog')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/blogs.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <p class="shop-hero__title">Our Blogs</p>
    </div>

    <!-- ============ Blog details ============ -->
    <!-- No Figma frame for this page: built as the Blog page. js/main.js fills it from js/blogs.js
         for blog-details.html?post=<slug> (no slug: the first post), adds the previous / next
         links and related stories and, for a slug that isn't there, says the story wasn't found. -->
    <article class="post" aria-labelledby="post-title" data-post-page>
      <div data-post-content>
        <header class="post__head">
          <nav class="job__crumbs post__crumbs" aria-label="Breadcrumb"><a href="blog.html">Blogs</a><span aria-hidden="true">/</span><span aria-current="page" data-post-crumb></span></nav>
          <span class="blog-card__tag" data-post-tag></span>
          <h1 class="post__title" id="post-title" data-post-title></h1>
          <p class="post__meta">By Mighty Silks Team · <time data-post-date></time> · <span data-post-read></span></p>
        </header>

        <figure class="post__hero"><img data-post-image src="" alt=""></figure>

        <div class="post__layout">
          <div class="post__body" data-post-body></div>

          <aside class="post__aside">
            <div class="post__share">
              <p class="post__aside-title">Share this story</p>
              <div class="post__share-links">
                <a class="post__share-btn" href="#" target="_blank" rel="noopener" aria-label="Share on WhatsApp" data-share="whatsapp"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 20l1.3-3.8A8 8 0 1 1 8 19z"/><path d="M9 9.5c0 3 2.5 5.5 5.5 5.5l1-1.3-1.8-.9-.8.8a4 4 0 0 1-2-2l.8-.8-.9-1.8z"/></svg></a>
                <a class="post__share-btn" href="#" target="_blank" rel="noopener" aria-label="Share on Facebook" data-share="facebook"><img src="assets/footer/facebook.svg" alt=""></a>
                <a class="post__share-btn" href="#" target="_blank" rel="noopener" aria-label="Share on Pinterest" data-share="pinterest"><img src="assets/footer/pinterest.svg" alt=""></a>
                <button class="post__share-btn" type="button" aria-label="Copy link" data-share-copy><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1"/><path d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/></svg></button>
              </div>
              <p class="post__copied" role="status" data-share-status></p>
            </div>
            <div class="post__shop">
              <p class="post__aside-title">Shop the Look</p>
              <p>Discover pieces inspired by this story in our collection.</p>
              <a class="pdp-btn pdp-btn--solid post__shop-btn" href="our-shop.html" data-post-shop>Shop Now</a>
            </div>
          </aside>
        </div>

        <nav class="post__pager" aria-label="More stories">
          <a class="post__pager-link post__pager-link--prev" href="#" data-post-prev><span class="post__pager-label">‹ Previous Story</span><span class="post__pager-title"></span></a>
          <a class="post__pager-link post__pager-link--next" href="#" data-post-next><span class="post__pager-label">Next Story ›</span><span class="post__pager-title"></span></a>
        </nav>
      </div>

      <div class="job__missing" data-post-missing hidden>
        <h1 class="about-heading">Story Not Found</h1>
        <p>The story you're looking for isn't here. Take a look at our latest stories instead.</p>
        <a class="pdp-btn pdp-btn--solid about-btn" href="blog.html">See All Stories</a>
      </div>
    </article>

    <!-- Related stories (the Blog page's cards). -->
    <section class="blog-latest post-related" aria-labelledby="post-related-title" data-post-related-section>
      <div class="blog-latest__head">
        <div>
          <p class="about-eyebrow">Keep Reading</p>
          <h2 class="about-heading" id="post-related-title">You May Also Like</h2>
        </div>
        <a class="blog-post__more" href="blog.html">View All Stories <span aria-hidden="true">→</span></a>
      </div>
      <div class="blog-list" data-post-related></div>
    </section>

    <!-- Newsletter (as the Blog page). -->
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
