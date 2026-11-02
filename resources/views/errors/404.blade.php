@extends('layouts.site')

@section('title', 'Mighty Silks — Page Not Found')

{{-- The site links its assets and pages relatively (css/styles.css, /about), so a missing
     nested URL (/orders/x/y) would look for them under that path; resolve them from the root. --}}
@section('head')
<base href="{{ url('/') }}/">
@endsection

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Not found ============ -->
    <!-- No Figma frame for this page: the checkout message's centred layout, with a few ways back in. -->
    <section class="not-found" aria-labelledby="not-found-title">
      {{-- The illustration: errors/art/hoop (embroidery hoop) or errors/art/spool (thread spool). --}}
      @include('errors.art.hoop')
      <p class="about-eyebrow">Error 404 · Page not found</p>
      <h1 class="not-found__title" id="not-found-title">This thread seems to have come loose.</h1>
      <p class="not-found__lead">The page you're looking for may have moved, sold out or never existed. Let's get you back to the collections.</p>

      <div class="not-found__actions">
        <a class="pdp-btn pdp-btn--solid" href="{{ url('/') }}">Back to Home</a>
        <a class="pdp-btn pdp-btn--outline" href="our-shop">Shop All</a>
      </div>

      <nav class="not-found__links" aria-label="Popular pages">
        <p>Or try one of these:</p>
        <ul>
          <li><a href="new-arrivals">New Arrivals</a></li>
          <li><a href="sarees">Sarees</a></li>
          <li><a href="bridal">Bridal</a></li>
          <li><a href="track-order">Track Order</a></li>
          <li><a href="help-center">Help Center</a></li>
        </ul>
      </nav>
    </section>

  </main>
@endsection
