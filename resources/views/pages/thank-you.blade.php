@extends('layouts.site')

@section('title', 'Mighty Silks — Thank You')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@php
  // thank-you.html?order=<number>: thanks for that order and links to it; otherwise a general thank-you.
  $order = preg_match('/^[A-Za-z0-9-]{1,32}$/', (string) request('order')) ? request('order') : null;
@endphp

@section('content')
<main>

    <!-- ============ Thank you ============ -->
    <!-- No Figma frame for this page: the 404 page's centred layout and embroidery-hoop art, here
         with a heart stitched into the fabric. With an order number it adds what happens next. -->
    <section class="thanks" aria-labelledby="thanks-title">
      {{-- The illustration: partials/thanks/gift (gift box) or partials/thanks/hoop (stitched heart). --}}
      @include('partials.thanks.gift')

      @if ($order)
        <p class="about-eyebrow">Order #{{ $order }} confirmed</p>
        <h1 class="thanks__title" id="thanks-title">Thank you for your order!</h1>
        <p class="thanks__lead">We've received your order and sent a confirmation to your email. Our team is already getting your pieces ready with care.</p>
      @else
        <p class="about-eyebrow">Thank you</p>
        <h1 class="thanks__title" id="thanks-title">Thank you for choosing Mighty Silks.</h1>
        <p class="thanks__lead">We've received your details and our team will be in touch shortly. In the meantime, there's plenty more to discover.</p>
      @endif

      <div class="thanks__actions">
        @if ($order)
          <a class="pdp-btn pdp-btn--solid" href="order-details.html?order={{ $order }}">View Order</a>
        @endif
        <a class="pdp-btn {{ $order ? 'pdp-btn--outline' : 'pdp-btn--solid' }}" href="our-shop.html">Continue Shopping</a>
        @unless ($order)
          <a class="pdp-btn pdp-btn--outline" href="index.html">Back to Home</a>
        @endunless
      </div>

      @if ($order)
        <ol class="thanks__steps" aria-label="What happens next">
          <li>
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
            <strong>Confirmation</strong>
            <span>Your order details are in your inbox.</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 8 12 3 3 8v8l9 5 9-5z"/><path d="m3 8 9 5 9-5M12 13v8"/></svg>
            <strong>Packed with care</strong>
            <span>Each piece is checked and wrapped by hand.</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h11v10H3zM14 9h4l3 3v4h-7"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>
            <strong>On its way</strong>
            <span>Follow it any time on <a href="track-order.html">Track Order</a>.</span>
          </li>
        </ol>
      @endif

      <p class="thanks__help">Questions? Visit our <a href="help-center.html">Help Center</a> or write to <a href="mailto:info@mightysilks.ae">info@mightysilks.ae</a>.</p>
    </section>

  </main>
@endsection
