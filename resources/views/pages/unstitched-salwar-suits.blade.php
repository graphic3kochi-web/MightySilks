@extends('layouts.site')

@section('title', 'Mighty Silks — Unstitched Salwar Suits')

@section('scripts')
<script defer src="js/main.js"></script>
<script defer src="js/products.js"></script>
<script defer src="js/shop.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (Figma 261:978 / 261:979) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Unstitched Salwar Suits</h1>
    </div>

    <!-- ============ Filters + sort (Figma 261:987 – 261:1003) ============ -->
    <!-- js/shop.js opens the drop-downs and filters / sorts the grid. -->
    <div class="shop-toolbar" data-shop-toolbar>
      <button class="shop-toolbar__label" type="button" aria-controls="filter-panel" aria-expanded="false" data-filter-open><span class="shop-toolbar__icon"><img src="assets/icons/filter.svg" alt=""></span><span data-filter-total>Filters</span></button>

      <div class="shop-filters">
        <div class="shop-dropdown" data-dropdown>
          <button class="shop-dropdown__btn" type="button" aria-expanded="false" aria-controls="filter-price"><span data-label="Price">Price</span><img src="assets/icons/caret-down.svg" alt=""></button>
          <!-- Price range: two-thumb slider plus From / To fields (js/shop.js sets the limits from
               the product prices and keeps this and the drawer's copy in sync). -->
          <fieldset class="shop-dropdown__panel shop-dropdown__panel--list shop-dropdown__panel--range" id="filter-price" hidden>
            <legend class="visually-hidden">Price</legend>
            <div class="price-range" data-price-range>
              <div class="price-range__head">
                <span class="price-range__title">Price</span>
                <button class="price-range__reset" type="button" data-price-reset>Reset</button>
              </div>
              <div class="price-range__slider">
                <input type="range" min="0" step="1" aria-label="Minimum price" data-price-thumb="min">
                <input type="range" min="0" step="1" aria-label="Maximum price" data-price-thumb="max">
              </div>
              <div class="price-range__fields">
                <label class="price-range__field"><span>From</span><input type="number" min="0" step="1" inputmode="numeric" data-price-field="min"></label>
                <label class="price-range__field"><span>To</span><input type="number" min="0" step="1" inputmode="numeric" data-price-field="max"></label>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="shop-dropdown" data-dropdown>
          <button class="shop-dropdown__btn" type="button" aria-expanded="false" aria-controls="filter-color"><span data-label="Color">Color</span><img src="assets/icons/caret-down.svg" alt=""></button>
          <!-- Colours with the number of matching products (js/shop.js); the list scrolls. -->
          <fieldset class="shop-dropdown__panel shop-dropdown__panel--list shop-dropdown__panel--scroll" id="filter-color" hidden>
            <legend class="visually-hidden">Color</legend>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="green"><span class="shop-option__swatch" style="--swatch:#2e8b3d"></span><span>Green</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="pink"><span class="shop-option__swatch" style="--swatch:#f4a6c0"></span><span>Pink</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="red"><span class="shop-option__swatch" style="--swatch:#d62828"></span><span>Red</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="multi"><span class="shop-option__swatch" style="--swatch:conic-gradient(#e53935, #fdd835, #43a047, #1e88e5, #8e24aa, #e53935)"></span><span>Multi</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="black"><span class="shop-option__swatch" style="--swatch:#111111"></span><span>Black</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="maroon"><span class="shop-option__swatch" style="--swatch:#7b1e2b"></span><span>Maroon</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="yellow"><span class="shop-option__swatch" style="--swatch:#f5d50a"></span><span>Yellow</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="beige"><span class="shop-option__swatch" style="--swatch:#d9c4a0"></span><span>Beige</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="gray"><span class="shop-option__swatch" style="--swatch:#8e8e8e"></span><span>Gray</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="mustard"><span class="shop-option__swatch" style="--swatch:#d4a017"></span><span>Mustard</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="bottle-green"><span class="shop-option__swatch" style="--swatch:#0b5d3b"></span><span>Bottle Green</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="purple"><span class="shop-option__swatch" style="--swatch:#6a2c91"></span><span>Purple</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="blue"><span class="shop-option__swatch" style="--swatch:#1565d8"></span><span>Blue</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="dark-pink"><span class="shop-option__swatch" style="--swatch:#c2185b"></span><span>Dark Pink</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="sandal"><span class="shop-option__swatch" style="--swatch:#e8c99b"></span><span>Sandal</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="orange"><span class="shop-option__swatch" style="--swatch:#f57c00"></span><span>Orange</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="sea-green"><span class="shop-option__swatch" style="--swatch:#2e8b57"></span><span>Sea Green</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="brown"><span class="shop-option__swatch" style="--swatch:#a0522d"></span><span>Brown</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="off-white"><span class="shop-option__swatch" style="--swatch:#f6f1e4"></span><span>Off White</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="peach"><span class="shop-option__swatch" style="--swatch:#ffcba4"></span><span>Peach</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="magenta"><span class="shop-option__swatch" style="--swatch:#c4007a"></span><span>Magenta</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="peacock-blue"><span class="shop-option__swatch" style="--swatch:#00677e"></span><span>Peacock Blue</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="navy-blue"><span class="shop-option__swatch" style="--swatch:#1f2a5c"></span><span>Navy Blue</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="cream"><span class="shop-option__swatch" style="--swatch:#f5f0c8"></span><span>Cream</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="sky-blue"><span class="shop-option__swatch" style="--swatch:#87ceeb"></span><span>Sky Blue</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="pista-green"><span class="shop-option__swatch" style="--swatch:#b5d48c"></span><span>Pista Green</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="lavender"><span class="shop-option__swatch" style="--swatch:#b9a7e0"></span><span>Lavender</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="rose-pink"><span class="shop-option__swatch" style="--swatch:#e8789a"></span><span>Rose Pink</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="parrot-green"><span class="shop-option__swatch" style="--swatch:#4cbb17"></span><span>Parrot Green</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="mehandi-green"><span class="shop-option__swatch" style="--swatch:#6b7a2e"></span><span>Mehandi Green</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="light-blue"><span class="shop-option__swatch" style="--swatch:#add8e6"></span><span>Light Blue</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="light-green"><span class="shop-option__swatch" style="--swatch:#9ed99a"></span><span>Light Green</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="rose-gold"><span class="shop-option__swatch" style="--swatch:#b76e79"></span><span>Rose Gold</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="coral"><span class="shop-option__swatch" style="--swatch:#ff7f50"></span><span>Coral</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="turquoise"><span class="shop-option__swatch" style="--swatch:#30d5c8"></span><span>Turquoise</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="rani-pink"><span class="shop-option__swatch" style="--swatch:#e6007e"></span><span>Rani Pink</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="royal-blue"><span class="shop-option__swatch" style="--swatch:#2a4fb5"></span><span>Royal Blue</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="gold"><span class="shop-option__swatch" style="--swatch:#d4af37"></span><span>Gold</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="coffee-brown"><span class="shop-option__swatch" style="--swatch:#4b3621"></span><span>Coffee Brown</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="violet"><span class="shop-option__swatch" style="--swatch:#7f3fbf"></span><span>Violet</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="rust"><span class="shop-option__swatch" style="--swatch:#b7410e"></span><span>Rust</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="brick-orange"><span class="shop-option__swatch" style="--swatch:#c8501e"></span><span>Brick Orange</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="mauve"><span class="shop-option__swatch" style="--swatch:#b784a7"></span><span>Mauve</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="lemon-yellow"><span class="shop-option__swatch" style="--swatch:#fff44f"></span><span>Lemon Yellow</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="teal"><span class="shop-option__swatch" style="--swatch:#008080"></span><span>Teal</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="white"><span class="shop-option__swatch" style="--swatch:#ffffff"></span><span>White</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="golden-peach"><span class="shop-option__swatch" style="--swatch:#f3c48a"></span><span>Golden Peach</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="dark-beige"><span class="shop-option__swatch" style="--swatch:#b8a07e"></span><span>Dark Beige</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="blue-gray"><span class="shop-option__swatch" style="--swatch:#6c7f99"></span><span>Blue Gray</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="burgundy"><span class="shop-option__swatch" style="--swatch:#6d1a36"></span><span>Burgundy</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="mint-green"><span class="shop-option__swatch" style="--swatch:#98e0b8"></span><span>Mint Green</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="sage-green"><span class="shop-option__swatch" style="--swatch:#9caf88"></span><span>Sage Green</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="deep-red"><span class="shop-option__swatch" style="--swatch:#9b111e"></span><span>Deep Red</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="golden"><span class="shop-option__swatch" style="--swatch:#e1b33a"></span><span>Golden</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="dark-blue"><span class="shop-option__swatch" style="--swatch:#0d2c6c"></span><span>Dark Blue</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count shop-option--swatch"><input type="checkbox" name="color" value="lilac"><span class="shop-option__swatch" style="--swatch:#c8a2c8"></span><span>Lilac</span><span class="shop-option__count" data-count></span></label>
          </fieldset>
        </div>
        <div class="shop-dropdown" data-dropdown>
          <button class="shop-dropdown__btn" type="button" aria-expanded="false" aria-controls="filter-pattern"><span data-label="Pattern">Pattern</span><img src="assets/icons/caret-down.svg" alt=""></button>
          <!-- Patterns with the number of matching products (js/shop.js). -->
          <fieldset class="shop-dropdown__panel shop-dropdown__panel--list shop-dropdown__panel--scroll" id="filter-pattern" hidden>
            <legend class="visually-hidden">Pattern</legend>
            <label class="shop-option shop-option--count"><input type="checkbox" name="pattern" value="zari-butta"><span>Zari Butta</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count"><input type="checkbox" name="pattern" value="zari-brocade"><span>Zari Brocade</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count"><input type="checkbox" name="pattern" value="printed"><span>Printed</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count"><input type="checkbox" name="pattern" value="plain-body"><span>Plain Body</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count"><input type="checkbox" name="pattern" value="checks"><span>Checks</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count"><input type="checkbox" name="pattern" value="stripes"><span>Stripes</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count"><input type="checkbox" name="pattern" value="embroidery"><span>Embroidery</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count"><input type="checkbox" name="pattern" value="floral-print"><span>Floral Print</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count"><input type="checkbox" name="pattern" value="thread-butta"><span>Thread Butta</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count"><input type="checkbox" name="pattern" value="pure-ikat"><span>Pure Ikat</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count"><input type="checkbox" name="pattern" value="jacquard"><span>Jacquard</span><span class="shop-option__count" data-count></span></label>
            <label class="shop-option shop-option--count"><input type="checkbox" name="pattern" value="zari-thread-butta"><span>Zari And Thread Butta</span><span class="shop-option__count" data-count></span></label>
          </fieldset>
        </div>
      </div>

      <div class="shop-dropdown shop-sort" data-dropdown>
        <button class="shop-dropdown__btn" type="button" aria-expanded="false" aria-controls="sort-by" aria-label="Sort by"><span data-label="Featured">Featured</span><img src="assets/icons/caret-down.svg" alt=""></button>
        <fieldset class="shop-dropdown__panel" id="sort-by" hidden>
          <legend class="visually-hidden">Sort by</legend>
          <label class="shop-option"><input type="radio" name="sort" value="featured" checked>Featured</label>
          <label class="shop-option"><input type="radio" name="sort" value="new">New Arrivals</label>
          <label class="shop-option"><input type="radio" name="sort" value="price-asc">Price: Low to High</label>
          <label class="shop-option"><input type="radio" name="sort" value="price-desc">Price: High to Low</label>
          <label class="shop-option"><input type="radio" name="sort" value="name">Name: A to Z</label>
        </fieldset>
      </div>

      <div class="shop-rule shop-toolbar__rule"><img src="assets/icons/shop-rule.svg" alt=""></div>
    </div>

    <!-- ============ Product grid (Figma 261:1052 – 266:1319) ============ -->
    <!-- data-color (space-separated) and data-pattern are what the drop-downs filter on. -->
    <section class="shop-products" aria-label="Products">
      <div class="product-grid product-grid--shop" data-shop-grid>
@foreach ($products as $product)
@include('partials.product-card')
@endforeach
<!-- The Mahalekshmi Unstitched Salwar Suits collection -->
</div>

      <div class="shop-empty" data-shop-empty hidden>
        <p>No products match these filters.</p>
        <button class="view-all" type="button" data-shop-clear>Clear filters</button>
      </div>

      <!-- Figma 266:1320 -->
      <button class="shop-more" type="button">Load more...</button>
    </section>

  </main>
@endsection

@section('after')
<!-- Filter drawer: opened by the Filters button, slides in from the left (js/shop.js). Outside
     .page so it is not scaled with the desktop design frame. The Price / Color / Pattern lists are
     copied from the toolbar drop-downs (data-filter-copy) and kept in sync with them. -->
<div class="filter-panel" id="filter-panel" hidden>
  <div class="filter-panel__backdrop" data-filter-close></div>
  <aside class="filter-drawer" role="dialog" aria-modal="true" aria-labelledby="filter-title" tabindex="-1">
    <header class="filter-drawer__head">
      <span class="shop-toolbar__icon"><img src="assets/icons/filter.svg" alt=""></span>
      <h2 class="filter-drawer__title" id="filter-title">Filters</h2>
      <button class="filter-drawer__close" type="button" aria-label="Close filters" data-filter-close>
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
      </button>
    </header>
    <div class="filter-drawer__body">
      <details class="filter-section" open>
        <summary>Category<img src="assets/icons/caret-down.svg" alt=""></summary>
        <div class="filter-section__options">
          <label class="shop-option shop-option--count"><input type="checkbox" name="category" value="saree"><span>Saree</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="category" value="lacha"><span>Lacha</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="category" value="ready-to-wear"><span>Ready to Wear</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="category" value="gown"><span>Gown</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="category" value="dhawani"><span>Dhawani</span><span class="shop-option__count" data-count></span></label>
        </div>
      </details>
      <details class="filter-section">
        <summary>Price<img src="assets/icons/caret-down.svg" alt=""></summary>
        <div class="filter-section__options" data-filter-copy="filter-price"></div>
      </details>
      <details class="filter-section">
        <summary>Color<img src="assets/icons/caret-down.svg" alt=""></summary>
        <div class="filter-section__options" data-filter-copy="filter-color"></div>
      </details>
      <details class="filter-section">
        <summary>Fabric<img src="assets/icons/caret-down.svg" alt=""></summary>
        <div class="filter-section__options">
          <label class="shop-option shop-option--count"><input type="checkbox" name="fabric" value="pure-silk"><span>Pure Silk</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="fabric" value="semi-silk"><span>Semi Silk</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="fabric" value="banarasi-silk"><span>Banarasi Silk</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="fabric" value="organza"><span>Organza</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="fabric" value="chiffon"><span>Chiffon</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="fabric" value="georgette"><span>Georgette</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="fabric" value="net"><span>Net</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="fabric" value="cotton"><span>Cotton</span><span class="shop-option__count" data-count></span></label>
        </div>
      </details>
      <details class="filter-section">
        <summary>With Blouse<img src="assets/icons/caret-down.svg" alt=""></summary>
        <div class="filter-section__options">
          <label class="shop-option shop-option--count"><input type="checkbox" name="blouse" value="yes"><span>With Blouse</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="blouse" value="no"><span>Without Blouse</span><span class="shop-option__count" data-count></span></label>
        </div>
      </details>
      <details class="filter-section">
        <summary>Pattern<img src="assets/icons/caret-down.svg" alt=""></summary>
        <div class="filter-section__options" data-filter-copy="filter-pattern"></div>
      </details>
      <details class="filter-section">
        <summary>Occasion<img src="assets/icons/caret-down.svg" alt=""></summary>
        <div class="filter-section__options">
          <label class="shop-option shop-option--count"><input type="checkbox" name="occasion" value="wedding"><span>Wedding</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="occasion" value="bridal"><span>Bridal</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="occasion" value="festive"><span>Festive</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="occasion" value="party"><span>Party</span><span class="shop-option__count" data-count></span></label>
          <label class="shop-option shop-option--count"><input type="checkbox" name="occasion" value="casual"><span>Casual</span><span class="shop-option__count" data-count></span></label>
        </div>
      </details>
    </div>
    <footer class="filter-drawer__foot">
      <button class="filter-btn filter-btn--outline" type="button" data-shop-clear>Clear All</button>
      <button class="filter-btn filter-btn--primary" type="button" data-filter-close data-filter-show>Show 24 Products</button>
    </footer>
  </aside>
</div>
@endsection
