@extends('layouts.site')

@section('title', 'Mighty Silks — Home')

@section('scripts')
<script defer src="js/shader-runtime/webgpu.js"></script>
<script defer src="js/shader-runtime/shader-effect.js"></script>
<script defer src="js/effects/warp.js"></script>
<script defer src="js/main.js"></script>
<script defer src="js/products.js"></script>
@endsection

@section('header')
<!-- ============ Header: fixed over the page (not inside the pinned hero, so the sections that
     slide over the hero never cover it); clear over the hero, a dark bar once scrolled. ============ -->
  <nav class="site-header site-header--overlay" aria-label="Main">
    <a class="logo" href="#" aria-label="Mighty Silks home">
      <span class="logo__mark"><img src="assets/hero/logo-mark.png" alt=""></span>
      <img class="logo__wordmark" src="assets/hero/logo-mighty.svg" alt="">
      <span class="logo__silks">Silks</span>
    </a>

    <ul class="site-menu" id="site-menu">
      <li><a href="#" aria-label="Home"><span aria-hidden="true"><span class="site-menu__char" style="--i:0">H</span><span class="site-menu__char" style="--i:1">o</span><span class="site-menu__char" style="--i:2">m</span><span class="site-menu__char" style="--i:3">e</span></span></a></li>
      <li><a href="our-shop" aria-label="Our Shop"><span aria-hidden="true"><span class="site-menu__char" style="--i:0">O</span><span class="site-menu__char" style="--i:1">u</span><span class="site-menu__char" style="--i:2">r</span><span class="site-menu__char" style="--i:3"> </span><span class="site-menu__char" style="--i:4">S</span><span class="site-menu__char" style="--i:5">h</span><span class="site-menu__char" style="--i:6">o</span><span class="site-menu__char" style="--i:7">p</span></span></a></li>
      <li><a href="new-arrivals" aria-label="New Arrivals"><span aria-hidden="true"><span class="site-menu__char" style="--i:0">N</span><span class="site-menu__char" style="--i:1">e</span><span class="site-menu__char" style="--i:2">w</span><span class="site-menu__char" style="--i:3"> </span><span class="site-menu__char" style="--i:4">A</span><span class="site-menu__char" style="--i:5">r</span><span class="site-menu__char" style="--i:6">r</span><span class="site-menu__char" style="--i:7">i</span><span class="site-menu__char" style="--i:8">v</span><span class="site-menu__char" style="--i:9">a</span><span class="site-menu__char" style="--i:10">l</span><span class="site-menu__char" style="--i:11">s</span></span></a></li>
      <li><a href="bridal" aria-label="Bridal"><span aria-hidden="true"><span class="site-menu__char" style="--i:0">B</span><span class="site-menu__char" style="--i:1">r</span><span class="site-menu__char" style="--i:2">i</span><span class="site-menu__char" style="--i:3">d</span><span class="site-menu__char" style="--i:4">a</span><span class="site-menu__char" style="--i:5">l</span></span></a></li>
      <li><a href="sarees" aria-label="Sarees"><span aria-hidden="true"><span class="site-menu__char" style="--i:0">S</span><span class="site-menu__char" style="--i:1">a</span><span class="site-menu__char" style="--i:2">r</span><span class="site-menu__char" style="--i:3">e</span><span class="site-menu__char" style="--i:4">e</span><span class="site-menu__char" style="--i:5">s</span></span></a></li>
      <li><a href="mighty-signature" aria-label="Mighty Signature"><span aria-hidden="true"><span class="site-menu__char" style="--i:0">M</span><span class="site-menu__char" style="--i:1">i</span><span class="site-menu__char" style="--i:2">g</span><span class="site-menu__char" style="--i:3">h</span><span class="site-menu__char" style="--i:4">t</span><span class="site-menu__char" style="--i:5">y</span><span class="site-menu__char" style="--i:6"> </span><span class="site-menu__char" style="--i:7">S</span><span class="site-menu__char" style="--i:8">i</span><span class="site-menu__char" style="--i:9">g</span><span class="site-menu__char" style="--i:10">n</span><span class="site-menu__char" style="--i:11">a</span><span class="site-menu__char" style="--i:12">t</span><span class="site-menu__char" style="--i:13">u</span><span class="site-menu__char" style="--i:14">r</span><span class="site-menu__char" style="--i:15">e</span></span></a></li>
    </ul>

    <div class="site-actions">
      <button class="icon-btn site-actions__search" type="button" aria-label="Search" aria-controls="search-panel" aria-expanded="false"><img src="assets/icons/nav-search.svg" alt=""></button>
      <button class="icon-btn" type="button" aria-label="Wishlist"><img src="assets/icons/nav-heart.svg" alt=""></button>
      <button class="icon-btn site-actions__account" type="button" aria-label="Account" aria-controls="account-menu" aria-expanded="false" aria-haspopup="true"><img src="assets/icons/nav-user.svg" alt=""></button>
      <span class="site-actions__divider"><img src="assets/icons/nav-divider.svg" alt=""></span>
      <button class="icon-btn site-actions__bag" type="button" aria-label="Shopping bag" aria-controls="cart-panel" aria-expanded="false"><img src="assets/icons/nav-bag.svg" alt=""><span class="cart-badge" data-cart-badge aria-hidden="true" hidden>0</span></button>
    </div>

    <!-- Menu button: shown below 1200px, where the menu becomes a drop-down panel. -->
    <button class="nav-toggle" type="button" aria-label="Menu" aria-controls="site-menu" aria-expanded="false">
      <span class="nav-toggle__bar"></span><span class="nav-toggle__bar"></span><span class="nav-toggle__bar"></span>
    </button>
  </nav>

<!-- ============ Hero (Figma 147:8) ============ -->
  <!-- .hero-pin adds the scroll distance during which the hero stays pinned and plays its
       zoom/split animation (enabled by js/main.js). -->
  <div class="hero-pin">
  <header class="hero">
    <!-- .hero__art holds the artwork and copy (not the header) so smaller screens can scale or
         restack it on its own (css/styles.css). -->
    <div class="hero__art">
    <img class="hero__bg" src="assets/hero/hero-bg.png" alt="">
    <div class="hero__tint"></div>
    <div class="hero__shade"></div>

    <h1 class="visually-hidden">Mighty Silks — One Color, A Thousand Moods</h1>
    <p class="hero__text hero__text--thousand" aria-hidden="true"><span class="hero__word" data-split="left">Thousand</span> <span class="hero__word" data-split="right">Moods</span></p>
    <p class="hero__text hero__text--a" aria-hidden="true">A</p>

    <!-- Shader layer: Warp (Twist) applied to the model at 41% opacity. Ships pre-rendered;
         js/main.js swaps in the live WebGPU shader (input: data-shader-source) when available. -->
    <div class="hero__warp" id="hero-warp">
      <div class="hero__warp-content">
        <img src="assets/hero/hero-model-warp.png" data-shader-source="assets/hero/hero-model.png" alt="">
      </div>
    </div>
    <img class="hero__model" src="assets/hero/hero-model.png" alt="Model wearing a purple cotton handloom saree">

    <p class="hero__text hero__text--color" aria-hidden="true">Onr Color</p>
    <p class="hero__text hero__text--pure" aria-hidden="true">Pure You</p>
    <p class="hero__text hero__text--cotton" aria-hidden="true">Cotton that</p>
    <p class="hero__text hero__text--breathes" aria-hidden="true">Breathes.</p>
    <p class="hero__text hero__text--stays" aria-hidden="true">that Stays</p>
    <p class="hero__text hero__text--elegance" aria-hidden="true">Elegance</p>
    </div>
  </header>
  </div>

  @endsection

@section('content')
<main>

    <!-- .curtain-hold: during the hero's curtain reveal the Wedding section sticks to the top of
         the screen inside this wrapper (js/main.js / css/styles.css size it). -->
    <div class="curtain-hold">
    <!-- ============ Wedding collection (Figma 147:112) ============ -->
    <section class="section section--night wedding" id="bridal">
      <div class="section-head section-head--loose" data-reveal="scene">
        <h2 class="section-title float-title"><span class="float-title__word" style="--i:0">Wedding</span> <span class="float-title__word" style="--i:1">Collection</span></h2>
        <p class="section-subtitle zoom-in">Find your perfect drape,for every price</p>
      </div>
      <div class="wedding__grid" data-reveal="scene">
        <a class="arch-card" href="sarees" style="--i:0">
          <span class="arch-card__media" style="left:10.69px">
            <img src="assets/wedding/saree.png" alt="" style="--x:-59.672px;--y:-101.539px;--w:564.83px;--h:749.774px">
          </span>
          <span class="arch-card__title" style="left:142.80px">Saree</span>
          <span class="arch-card__sub" style="left:98.78px">Collections</span>
          <svg class="arch-card__trace" viewBox="0 0 417.367 621" aria-hidden="true"><path pathLength="1" d="M208.684 620.25H0.75V208.684A207.934 207.934 0 0 1 208.684 0.75A207.934 207.934 0 0 1 416.617 208.684V620.25Z"/></svg>
        </a>
        <a class="arch-card" href="gown" style="--i:1">
          <span class="arch-card__media">
            <img src="assets/wedding/gown.png" alt="" style="--x:-0.373px;--y:-12.595px;--w:398.447px;--h:597.67px">
          </span>
          <span class="arch-card__title" style="left:141.63px">Gown</span>
          <span class="arch-card__sub" style="left:102.80px">Collections</span>
          <svg class="arch-card__trace" viewBox="0 0 417.367 621" aria-hidden="true"><path pathLength="1" d="M208.684 620.25H0.75V208.684A207.934 207.934 0 0 1 208.684 0.75A207.934 207.934 0 0 1 416.617 208.684V620.25Z"/></svg>
        </a>
        <a class="arch-card" href="lahanga" style="--i:2">
          <span class="arch-card__media" style="left:10.69px">
            <img src="assets/wedding/lehenga.png" alt="" style="--x:-21.444px;--y:-27.24px;--w:418.911px;--h:629.792px">
          </span>
          <span class="arch-card__title" style="left:117.08px">Lahanga</span>
          <span class="arch-card__sub" style="left:129.64px">Collections</span>
          <svg class="arch-card__trace" viewBox="0 0 417.367 621" aria-hidden="true"><path pathLength="1" d="M208.684 620.25H0.75V208.684A207.934 207.934 0 0 1 208.684 0.75A207.934 207.934 0 0 1 416.617 208.684V620.25Z"/></svg>
        </a>
        <a class="arch-card" href="ready-to-wear" style="--i:3">
          <span class="arch-card__media" style="left:10.69px">
            <img src="assets/wedding/ready-to-wear.png" alt="" style="--x:-0.033px;--y:-6.887px;--w:394.766px;--h:592.149px">
          </span>
          <span class="arch-card__title" style="left:36.69px">Ready To Wear</span>
          <span class="arch-card__sub" style="left:204.63px;top:507px">Collections</span>
          <svg class="arch-card__trace" viewBox="0 0 417.367 621" aria-hidden="true"><path pathLength="1" d="M208.684 620.25H0.75V208.684A207.934 207.934 0 0 1 208.684 0.75A207.934 207.934 0 0 1 416.617 208.684V620.25Z"/></svg>
        </a>
      </div>
    </section>
    </div>

    <!-- ============ New arrivals (Figma 147:153) ============ -->
    <section class="section products products--new" id="new-arrivals">
      <div class="section-head" data-reveal="toggle">
        <h2 class="section-title float-title"><span class="float-title__word" style="--i:0">New</span> <span class="float-title__word" style="--i:1">Arrivals</span></h2>
        <p class="section-subtitle zoom-in">Explore What’s New This Season</p>
      </div>
      <div class="products__more"><a class="view-all" href="new-arrivals">View All New Arrivals</a></div>
      <div class="product-grid" data-reveal="toggle">
        <article class="product" style="--i:0">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/na-1.png" alt="Chiffon peacock green saree" style="--x:1px;--y:0px;--w:440px;--h:587px">
            <img class="product__photo product__photo--hover" src="assets/products/na-1-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=na-1">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=na-1">Chiffon Peacock Green Saree with Crystal Embellished Teardrop Lace Border and Plain Body</a></h3>
          <p class="product__price">₹ 3,580.00</p>
        </article>
        <article class="product" style="--i:1">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/na-2.png" alt="Organza peacock blue saree" style="--x:-8px;--y:-13px;--w:458px;--h:614px">
            <img class="product__photo product__photo--hover" src="assets/products/na-2-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=na-2">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=na-2">Organza Peacock Blue Black Lily Floral Butta Printed Saree with Beaded Zigzag Border</a></h3>
          <p class="product__price">₹ 3,550.00</p>
        </article>
        <article class="product" style="--i:2">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/na-3a.png" alt="" style="--x:-2px;--y:-12px;--w:454px;--h:599px">
            <img class="product__photo" src="assets/products/na-3b.png" alt="Organza cream teal wavy stripe saree" style="--x:-6px;--y:0px;--w:448px;--h:598px">
            <img class="product__photo product__photo--hover" src="assets/products/na-3-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=na-3">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=na-3">Organza Cream Teal Blue and Olive Golden Wavy Stripe Printed Saree with Beaded...</a></h3>
          <p class="product__price">₹ 3,330.00</p>
        </article>
        <article class="product" style="--i:3">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/na-4.png" alt="Organza pink floral embroidered saree" style="--x:-10px;--y:-15px;--w:457px;--h:613px">
            <img class="product__photo product__photo--hover" src="assets/products/na-4-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=na-4">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=na-4">Organza Pink Multicolor Floral Embroidered Scalloped Border Saree with Sequin Work</a></h3>
          <p class="product__price">₹ 13,900.00</p>
        </article>
      </div>
    </section>

    <!-- Slide scene (driven by js/main.js), on one pinned screen: the bride banner (.slide-still)
         zooms in to fill the screen; then Shop by Occasion (.slide-panel) slides in over it from
         the right. -->
    <div class="slide-pin">
    <div class="slide-pin__stage">

    <!-- ============ Grace worthy of a bride (Figma 147:201 / 147:202 / 147:207) ============ -->
    <section class="section banner-section banner-section--bride slide-still">
      <div class="bride-banner">
        <div class="bride-banner__media">
          <img class="bride-banner__a" src="assets/banners/bride-a.png" alt="">
          <div class="bride-banner__shade"></div>
          <img class="bride-banner__b" src="assets/banners/bride-b.png" alt="Bride and groom embracing at a candle-lit wedding">
        </div>
        <div class="bride-banner__text">
        <h2 class="bride-banner__heading">
          <span class="bride-banner__grace">Grace</span>
          <span class="bride-banner__worthy">Worthy</span>
          <span class="bride-banner__of">of a</span>
          <span class="bride-banner__bride">Bride</span>
        </h2>
        <p class="bride-banner__copy">Handcrafted <span class="text-gold">silk sarees</span> designed to make<br>your special day truly unforgettable.</p>
        </div>
      </div>
    </section>

    <!-- ============ Shop by occasion + Shop by pattern (Figma 147:213) ============ -->
    <section class="section section--black occasions slide-panel">
      <div class="section-head section-head--loose">
        <h2 class="section-title">Shop by Occasion</h2>
        <p class="section-subtitle">Inspired by women who wear tradition differently</p>
      </div>
      <div class="occasion-grid" data-reveal>
        <a class="occasion-card" href="christmas">
          <img class="occasion-card__base" src="assets/occasion/base.png" alt="">
          <img class="occasion-card__photo" src="assets/occasion/christmas.png" alt="" style="--x:0px;--y:0px;--w:447px;--h:560px">
          <span class="occasion-card__fade"></span>
          <span class="occasion-card__eyebrow"><img src="assets/occasion/line.svg" alt="">Top Picks For<img src="assets/occasion/line.svg" alt=""></span>
          <span class="occasion-card__title">Christmas</span>
          <span class="btn-shop">Shop Now</span>
        </a>
        <a class="occasion-card" href="diwali">
          <img class="occasion-card__base" src="assets/occasion/base.png" alt="">
          <img class="occasion-card__photo" src="assets/occasion/diwali.png" alt="" style="--x:0px;--y:0px;--w:448px;--h:621px">
          <span class="occasion-card__fade"></span>
          <span class="occasion-card__eyebrow"><img src="assets/occasion/line.svg" alt="">Top Picks For<img src="assets/occasion/line.svg" alt=""></span>
          <span class="occasion-card__title">Diwali</span>
          <span class="btn-shop">Shop Now</span>
        </a>
        <a class="occasion-card" href="dussehra">
          <img class="occasion-card__base" src="assets/occasion/base.png" alt="">
          <img class="occasion-card__photo" src="assets/occasion/dussehra.png" alt="" style="--x:-132px;--y:-45px;--w:711px;--h:1060px">
          <span class="occasion-card__fade"></span>
          <span class="occasion-card__eyebrow"><img src="assets/occasion/line.svg" alt="">Top Picks For<img src="assets/occasion/line.svg" alt=""></span>
          <span class="occasion-card__title">Dussehra</span>
          <span class="btn-shop">Shop Now</span>
        </a>
        <a class="occasion-card" href="navaratri">
          <img class="occasion-card__base" src="assets/occasion/base.png" alt="">
          <img class="occasion-card__photo" src="assets/occasion/navaratri.png" alt="" style="--x:0px;--y:0px;--w:452px;--h:566px">
          <span class="occasion-card__fade"></span>
          <span class="occasion-card__eyebrow"><img src="assets/occasion/line.svg" alt="">Top Picks For<img src="assets/occasion/line.svg" alt=""></span>
          <span class="occasion-card__title">Navaratri</span>
          <span class="btn-shop">Shop Now</span>
        </a>
      </div>

      <div class="pattern" data-pattern data-reveal>
        <h2 class="section-title pattern__title">Shop by Pattern</h2>
        <p class="section-subtitle pattern__subtitle">Pattern That Defines Every Occasion</p>

        <a class="pattern-pill pattern-pill--side" href="#" style="left:0;top:326px;--i:0" data-pattern-slot>
          <span class="pattern-pill__frame">
            <img src="assets/pattern/zari-woven.png" alt="" style="--x:-89px;--y:-22px;--w:327px;--h:451px">
          </span>
          <span class="pattern-pill__label">Zari Woven</span>
        </a>
        <a class="pattern-pill pattern-pill--main" href="pattern" style="left:208px;top:228px;--i:1" data-pattern-slot>
          <span class="pattern-pill__frame">
            <img src="assets/pattern/brocade.png" alt="" style="--x:-179px;--y:0px;--w:483px;--h:603px">
          </span>
          <span class="pattern-pill__label">Brocade</span>
          <span class="btn-shop">Shop Now</span>
        </a>
        <a class="pattern-pill pattern-pill--side" href="#" style="left:540px;top:326px;--i:2" data-pattern-slot>
          <span class="pattern-pill__frame">
            <img src="assets/pattern/check.png" alt="" style="--x:-13px;--y:-17px;--w:331px;--h:441px">
          </span>
          <span class="pattern-pill__label">Check</span>
        </a>

        <div class="pattern__pager">
          <img src="assets/pattern/pager.svg" alt="">
          <button class="pattern__pager-btn pattern__pager-btn--prev" type="button" aria-label="Previous pattern" data-pattern-prev></button>
          <button class="pattern__pager-btn pattern__pager-btn--next" type="button" aria-label="Next pattern" data-pattern-next></button>
        </div>

        <div class="pattern__feature" style="--i:3">
          <img src="assets/pattern/feature.png" alt="Three women in printed sarees sharing tea">
        </div>
      </div>
    </section>

    </div>
    </div>

    <!-- ============ A timeless expression of elegance (Figma 147:308) ============ -->
    <section class="section banner-section">
      <div class="timeless" data-reveal>
        <div class="timeless__media">
          <img class="timeless__glow" src="assets/banners/timeless-glow.png" alt="">
          <div class="timeless__glow-blur"><img src="assets/banners/timeless-glow.png" alt=""></div>
          <img class="timeless__photo" src="assets/banners/timeless-1.png" alt="Two brides in embroidered lehengas beneath stone arches">
          <img class="timeless__photo timeless__photo--mirror" src="assets/banners/timeless-2.png" alt="">
        </div>
        <div class="timeless__fade"></div>
        <h2 class="timeless__heading">
          <span class="timeless__a">A Timeless</span>
          <span class="timeless__expression">Expression</span>
          <span class="timeless__of">of </span>
          <span class="timeless__elegance">Elegance</span>
        </h2>
        <p class="timeless__sub">The Dhawani Collections</p>
      </div>
    </section>

    <!-- ============ Ready to wear sarees (Figma 147:374) ============ -->
    <section class="section section--black products products--rtw">
      <div class="section-head" data-reveal="toggle">
        <h2 class="section-title float-title"><span class="float-title__word" style="--i:0">Ready</span> <span class="float-title__word" style="--i:1">to</span> <span class="float-title__word" style="--i:2">Wear</span> <span class="float-title__word" style="--i:3">Sarees</span></h2>
        <p class="section-subtitle zoom-in">Expertly pre-stitched for a flawless drape, these sarees deliver timeless sophistication and effortless ease.</p>
      </div>
      <div class="products__more"><a class="view-all" href="ready-to-wear">View All Ready to Wear Sarees</a></div>
      <div class="product-grid" data-reveal="toggle">
        <article class="product" style="--i:0">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/rtw-1.png" alt="Powder blue ready to wear saree on a runway">
            <img class="product__photo product__photo--hover" src="assets/products/rtw-1-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=rtw-1">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=rtw-1">Powder Blue Ready to Wear Saree</a></h3>
          <p class="product__price">₹ 3,675.00</p>
        </article>
        <article class="product" style="--i:1">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/rtw-2.png" alt="Mocha beige ready to wear saree" style="--x:-4px;--y:-2px;--w:445px;--h:668px">
            <img class="product__photo product__photo--hover" src="assets/products/rtw-2-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=rtw-2">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=rtw-2">Mocha Beige Ready to Wear Saree with Ruffled Edging</a></h3>
          <p class="product__price">₹ 3,065.00</p>
        </article>
        <article class="product" style="--i:2">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/rtw-3.png" alt="Violet georgette ready to wear saree" style="--x:-6px;--y:-23px;--w:454px;--h:679px">
            <img class="product__photo product__photo--hover" src="assets/products/rtw-3-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=rtw-3">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=rtw-3">Violet Georgette Ready to Wear Saree with Designer...</a></h3>
          <p class="product__price">₹ 4,595.00</p>
        </article>
        <article class="product" style="--i:3">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/rtw-4.png" alt="Light sage green ready to wear saree" style="--x:-5px;--y:-33px;--w:451px;--h:676px">
            <img class="product__photo product__photo--hover" src="assets/products/rtw-4-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=rtw-4">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=rtw-4">Light Sage Green Ready to Wear Saree</a></h3>
          <p class="product__price">₹ 3,895.00</p>
        </article>
      </div>
    </section>

    <!-- ============ Saree collection carousel (Figma 147:375 – 147:474) ============ -->
    <section class="section section--ink saree-collection" id="sarees" data-carousel>
      <div class="section-head">
        <h2 class="section-title">Saree Collection</h2>
        <p class="section-subtitle">Discover what's fresh! Shop our latest arrivals now.</p>
      </div>

      <div class="carousel-card carousel-card--far carousel-card--left" style="left:169px;top:387px" data-slot>
        <img class="carousel-card__photo" src="assets/carousel/far-left.png" alt="Ivory Kerala saree with pink lotus print" style="--x:-91.844px;--y:-16px;--w:495.833px;--h:595px" data-caption="Kerala|Saree">
        <span class="carousel-card__fade" style="--x:0px;--w:461.64px;--h:567.764px"></span>
      </div>
      <div class="carousel-card carousel-card--far carousel-card--right" style="left:1435px;top:387px" data-slot>
        <img class="carousel-card__photo" src="assets/carousel/far-right.png" alt="Pink embroidered georgette saree" style="--x:-70.491px;--y:-13.257px;--w:490.491px;--h:588.589px" data-caption="Fancy|Saree">
        <span class="carousel-card__fade" style="--x:-5.486px;--w:464.065px;--h:570.747px"></span>
      </div>
      <div class="carousel-card carousel-card--near carousel-card--left" style="left:427px;top:371px" data-slot>
        <img class="carousel-card__photo" src="assets/carousel/left.png" alt="Grey ready to wear saree with sequinned blouse" style="--x:-95px;--y:-15.584px;--w:520.973px;--h:625.167px" data-caption="Ready to Wear|Saree">
        <span class="carousel-card__fade" style="--x:0px;--w:496.235px;--h:610.312px"></span>
      </div>
      <div class="carousel-card carousel-card--near carousel-card--right" style="left:1159px;top:371px" data-slot>
        <img class="carousel-card__photo" src="assets/carousel/right.png" alt="Red Banarasi saree with gold motifs" style="--x:-89.607px;--y:-8.345px;--w:510.574px;--h:612.689px" data-caption="Banarasi|Saree">
        <span class="carousel-card__fade" style="--x:-0.033px;--w:492.178px;--h:605.322px"></span>
      </div>
      <a class="carousel-card carousel-card--center" href="#" style="left:698px;top:348px" data-slot>
        <img class="carousel-card__photo" src="assets/carousel/center.png" alt="Kanchipuram silk saree" style="--x:-20px;--y:-16px;--w:560px;--h:672px" data-caption="Kanchipuram|Sarees">
        <span class="carousel-card__fade" style="--x:0px;--w:522px;--h:642px"></span>
        <span class="carousel-card__caption" data-caption-target>
          <span class="carousel-card__name">Kanchipuram</span>
          <span class="carousel-card__kind">Sarees</span>
        </span>
      </a>

      <button class="carousel-nav carousel-nav--prev" type="button" aria-label="Previous saree" data-carousel-prev><img src="assets/carousel/prev.svg" alt=""></button>
      <button class="carousel-nav carousel-nav--next" type="button" aria-label="Next saree" data-carousel-next><img src="assets/carousel/next.svg" alt=""></button>

      <div class="carousel-pager">
        <button class="carousel-pager__arrow" type="button" aria-label="Previous saree" data-carousel-prev><img src="assets/carousel/arrow.svg" alt=""></button>
        <span class="carousel-pager__dot is-active"></span>
        <span class="carousel-pager__dot"></span>
        <span class="carousel-pager__dot"></span>
        <span class="carousel-pager__dot"></span>
        <span class="carousel-pager__dot"></span>
        <span class="carousel-pager__dot"></span>
        <button class="carousel-pager__arrow carousel-pager__arrow--next" type="button" aria-label="Next saree" data-carousel-next><img src="assets/carousel/arrow.svg" alt=""></button>
      </div>
    </section>

    <!-- ============ Bridal gowns (Figma 159:1726) ============ -->
    <!-- .curtain-reveal: the white sheet opens from a thin line when revealed, then the heading
         and cards come in (css/styles.css). -->
    <section class="section products products--gowns curtain-reveal" data-reveal>
      <div class="curtain-reveal__sheet" aria-hidden="true"></div>
      <div class="section-head">
        <h2 class="section-title float-title"><span class="float-title__word" style="--i:0">Bridal</span> <span class="float-title__word" style="--i:1">Gowns</span></h2>
        <p class="section-subtitle zoom-in">Wedding gowns designed to make your special day memorable.</p>
      </div>
      <div class="products__more"><a class="view-all" href="bridal">View All Bridal Gowns</a></div>
      <div class="product-grid" data-reveal="toggle">
        <article class="product" style="--i:0">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/bg-1.png" alt="White net bridal gown with veil" style="--x:0.875px;--y:-31.833px;--w:440.125px;--h:683.378px">
            <img class="product__photo product__photo--hover" src="assets/products/bg-1-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=bg-1">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=bg-1">White Net Bridal Gown with Veil</a></h3>
          <p class="product__price">₹ 31,875.00</p>
        </article>
        <article class="product" style="--i:1">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/bg-2.png" alt="White designer bridal gown with veil" style="--x:-8px;--y:-13px;--w:449px;--h:697.158px">
            <img class="product__photo product__photo--hover" src="assets/products/bg-2-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=bg-2">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=bg-2">White Designer Bridal Gown with Veil</a></h3>
          <p class="product__price">₹ 27,945.00</p>
        </article>
        <article class="product" style="--i:2">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/na-3a.png" alt="" style="--x:-2px;--y:-12px;--w:454px;--h:599px">
            <img class="product__photo" src="assets/products/bg-3b.png" alt="White net designer gown with contrast designs" style="--x:-6px;--y:0px;--w:447px;--h:670.919px">
            <img class="product__photo product__photo--hover" src="assets/products/bg-3-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=bg-3">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=bg-3">White Net Designer Gown with Contrast Designs</a></h3>
          <p class="product__price">₹ 31,875.00</p>
        </article>
        <article class="product" style="--i:3">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo product__photo--fill" src="assets/products/bg-4.png" alt="White designer net bridal gown with veil">
            <img class="product__photo product__photo--hover" src="assets/products/bg-4-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=bg-4">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=bg-4">White Designer Net Bridal Gown with Veil</a></h3>
          <p class="product__price">₹ 21,575.00</p>
        </article>
      </div>
    </section>

    <!-- ============ Lachas (Figma 166:1801) ============ -->
    <section class="section section--black products products--lachas curtain-reveal curtain-reveal--horizontal" data-reveal>
      <div class="curtain-reveal__sheet" aria-hidden="true"></div>
      <div class="section-head">
        <h2 class="section-title float-title"><span class="float-title__word" style="--i:0">Lachas</span></h2>
        <p class="section-subtitle zoom-in">Find Your Perfect Lacha Dress from Our Exclusive Ethnic Wear Collection</p>
      </div>
      <div class="products__more"><a class="view-all" href="#">View All Lachas</a></div>
      <div class="product-grid" data-reveal="toggle">
        <article class="product" style="--i:0">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/rtw-1a.png" alt="" style="--x:-0.494px;--y:-5.744px;--w:442.988px;--h:664.482px">
            <img class="product__photo" src="assets/products/la-1b.png" alt="Mint green lacha with floral vine embroidery" style="--x:-2.205px;--y:-19.016px;--w:445.41px;--h:609.03px">
            <img class="product__photo product__photo--hover" src="assets/products/la-1-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=la-1">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=la-1">Mint Green Lacha with Silver Gold Floral Vine Embroidery</a></h3>
          <p class="product__price">₹ 5,195.00</p>
        </article>
        <article class="product" style="--i:1">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/la-2.png" alt="Powder blue lacha with silver embroidery" style="--x:0px;--y:-2px;--w:441.934px;--h:590.248px">
            <img class="product__photo product__photo--hover" src="assets/products/la-2-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=la-2">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=la-2">Powder Blue With Silver Embroidered Lacha</a></h3>
          <p class="product__price">₹ 26,895.00</p>
        </article>
        <article class="product" style="--i:2">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo product__photo--fill" src="assets/products/la-3.png" alt="Ivory and gold embroidered lacha with net dupatta">
            <img class="product__photo product__photo--hover" src="assets/products/la-3-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=la-3">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=la-3">Violet Georgette Ready to Wear Saree with Designer...</a></h3>
          <p class="product__price">₹ 4,595.00</p>
        </article>
        <article class="product" style="--i:3">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/la-4.png" alt="Laurel green Arabic lacha" style="--x:-3.457px;--y:-4.601px;--w:447.913px;--h:596.202px">
            <img class="product__photo product__photo--hover" src="assets/products/la-4-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=la-4">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=la-4">Laurel Green Arabic Lacha in Designer Net and Shimmer Chiffon</a></h3>
          <p class="product__price">₹ 4,995.00</p>
        </article>
      </div>
    </section>

    <!-- ============ Dhawani collection (Figma 169:1894) ============ -->
    <section class="section section--ink products products--dhawani curtain-reveal curtain-reveal--zoom" data-reveal>
      <div class="curtain-reveal__sheet" aria-hidden="true"></div>
      <div class="section-head">
        <h2 class="section-title float-title"><span class="float-title__word" style="--i:0">Dhawani</span> <span class="float-title__word" style="--i:1">Collection</span></h2>
        <p class="section-subtitle zoom-in">Traditional dhavani sets designed for festive days and cultural celebrations.</p>
      </div>
      <div class="products__more"><a class="view-all" href="dhawani-collection">View All Dhawani Collections</a></div>
      <div class="product-grid" data-reveal="toggle">
        <article class="product" style="--i:0">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/dh-1.png" alt="Ivory floral print stitched dhawani set" style="--x:-11.303px;--y:-15.818px;--w:463.606px;--h:618.637px">
            <img class="product__photo product__photo--hover" src="assets/products/dh-1-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=dh-1">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=dh-1">Ivory Floral Print Stitched Dhawani Set</a></h3>
          <p class="product__price">₹ 3,695.00</p>
        </article>
        <article class="product" style="--i:1">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/dh-2.png" alt="Royal blue Banarasi silk stitched dhavani set" style="--x:-5px;--y:-8.689px;--w:451px;--h:603.409px">
            <img class="product__photo product__photo--hover" src="assets/products/dh-2-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=dh-2">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=dh-2">Royal Blue Banarasi Silk Stitched Dhavani Set</a></h3>
          <p class="product__price">₹ 14,895.00</p>
        </article>
        <article class="product" style="--i:2">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo product__photo--fill" src="assets/products/dh-3.png" alt="Peach orange Banarasi silk stitched dhavani set">
            <img class="product__photo product__photo--hover" src="assets/products/dh-3-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=dh-3">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=dh-3">Peach Orange Banarasi Silk Stitched Dhavani Set</a></h3>
          <p class="product__price">₹ 13,875.00</p>
        </article>
        <article class="product" style="--i:3">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/dh-4.png" alt="Ivory and deep bottle green Banarasi silk stitched dhavani set" style="--x:0.864px;--y:-4.601px;--w:441px;--h:591.601px">
            <img class="product__photo product__photo--hover" src="assets/products/dh-4-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p=dh-4">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product?p=dh-4">Ivory and Deep Bottle Green Banarasi Silk Stitched Dhavani Set</a></h3>
          <p class="product__price">₹ 4,995.00</p>
        </article>
      </div>
    </section>

    <!-- ============ Our blogs (Figma 171:1955) ============ -->
    <section class="section blogs">
      <div class="section-head">
        <h2 class="section-title">Our Blogs</h2>
        <p class="section-subtitle">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
      </div>
      <div class="blog-grid">
        <article class="blog-card">
          <a class="blog-card__media" href="blog-details?post=bridal-kanchipuram-saree-trends-2026"><span class="blog-card__crop">
            <img src="assets/blogs/blog-1.png" alt="Bride in a pastel Kanchipuram saree" style="--x:-162.607px;--y:-0.008px;--w:755.213px;--h:431.42px">
          </span></a>
          <span class="blog-card__tag">Bridal Kanchipuram Saree</span>
          <h3 class="blog-card__title"><a href="blog-details?post=bridal-kanchipuram-saree-trends-2026">Bridal Kanchipuram Saree Trends 2026: Pastel Shades, Lightweight Weaves &amp; Minimal Zari</a></h3>
        </article>
        <article class="blog-card">
          <a class="blog-card__media" href="blog-details?post=manthrakodi-saree-styles-christian-brides"><span class="blog-card__crop">
            <img src="assets/blogs/blog-2.png" alt="Two women in Manthrakodi sarees" style="--x:-160.64px;--y:-0.008px;--w:751.66px;--h:429.39px">
          </span></a>
          <span class="blog-card__tag">Manthrakodi Saree</span>
          <h3 class="blog-card__title"><a href="blog-details?post=manthrakodi-saree-styles-christian-brides">Traditional and Modern Manthrakodi Saree Styles for Christian Brides</a></h3>
        </article>
        <article class="blog-card">
          <a class="blog-card__media" href="blog-details?post=best-onam-churidar-designs"><span class="blog-card__crop">
            <img src="assets/blogs/blog-3.png" alt="Three women in Onam churidars" style="--x:-105.493px;--y:0px;--w:592.986px;--h:430.788px">
          </span></a>
          <span class="blog-card__tag">Onam Churidar</span>
          <h3 class="blog-card__title"><a href="blog-details?post=best-onam-churidar-designs">10 Best Onam Churidar Designs to Shop This Festive Season</a></h3>
        </article>
        <article class="blog-card">
          <a class="blog-card__media" href="blog-details?post=traditional-vs-modern-dhavani-designs"><span class="blog-card__crop">
            <img src="assets/blogs/blog-4.png" alt="Three women in dhavani sets" style="--x:-162.593px;--y:0px;--w:751.696px;--h:429.411px">
          </span></a>
          <span class="blog-card__tag">Dhavani Designs</span>
          <h3 class="blog-card__title"><a href="blog-details?post=traditional-vs-modern-dhavani-designs">Traditional vs Modern Dhavani Designs: Which Style Is Right for You?</a></h3>
        </article>
        <article class="blog-card">
          <a class="blog-card__media" href="blog-details?post=puliyilakkara-set-mundu-onam"><span class="blog-card__crop">
            <img src="assets/blogs/blog-5.png" alt="Three women in Puliyilakkara set mundu at an Onam celebration">
          </span></a>
          <span class="blog-card__tag">Puliyilakkara Set Mundu</span>
          <h3 class="blog-card__title"><a href="blog-details?post=puliyilakkara-set-mundu-onam">Why Wearing a Puliyilakkara Set Mundu During Onam Is a Celebration of Kerala Identity</a></h3>
        </article>
        <article class="blog-card">
          <a class="blog-card__media" href="blog-details?post=onam-churidar-designs-college-girls"><span class="blog-card__crop">
            <img src="assets/blogs/blog-6.png" alt="Three young women in Onam churidars sitting on steps">
          </span></a>
          <span class="blog-card__tag">Onam Churidar</span>
          <h3 class="blog-card__title"><a href="blog-details?post=onam-churidar-designs-college-girls">Best Onam Churidar Designs for College Girls and Young Women</a></h3>
        </article>
      </div>
    </section>

  </main>
@endsection
