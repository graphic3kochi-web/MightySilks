@extends('layouts.site')

@section('title', 'Mighty Silks — Shipping Policy')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Shipping Policy</h1>
    </div>

    <!-- ============ Shipping policy ============ -->
    <!-- No Figma frame for this page: the Privacy Policy's layout (a contents list that stays in
         view beside the text). js/main.js marks the section being read in the list. The rates
         match the checkout's (js/main.js SHIPPING). -->
    <div class="policy" data-policy>
      <aside class="policy__toc" aria-labelledby="policy-toc-title">
        <p class="policy__toc-title" id="policy-toc-title">Contents</p>
        <ol class="policy__toc-list">
          <li><a href="#overview">Overview</a></li>
          <li><a href="#options">Shipping Options &amp; Charges</a></li>
          <li><a href="#processing">Order Processing</a></li>
          <li><a href="#delivery-times">Delivery Times</a></li>
          <li><a href="#tracking">Tracking Your Order</a></li>
          <li><a href="#address">Delivery Address</a></li>
          <li><a href="#receiving">Receiving Your Order</a></li>
          <li><a href="#failed">Failed Deliveries</a></li>
          <li><a href="#damaged">Damaged or Missing Items</a></li>
          <li><a href="#international">International Shipping</a></li>
          <li><a href="#contact">Contact Us</a></li>
        </ol>
      </aside>

      <article class="policy__body">
        <p class="policy__updated">Last updated: <time datetime="2026-10-29">29 October 2026</time></p>
        <p class="policy__lead">We carefully pack every Mighty Silks order so it reaches you in perfect condition. This policy explains our delivery options, charges and timelines, and what to do if anything goes wrong.</p>

        <section id="overview">
          <h2><span>1.</span> Overview</h2>
          <p>This Shipping Policy applies to all orders placed on the Mighty Silks website. We currently deliver across India. It should be read together with our <a href="terms-and-conditions">Terms &amp; Conditions</a> and <a href="payment-policy">Payment Policy</a>.</p>
        </section>

        <section id="options">
          <h2><span>2.</span> Shipping Options &amp; Charges</h2>
          <p>Choose your delivery option at checkout:</p>
          <div class="policy__table-wrap">
            <table class="policy__table">
              <thead>
                <tr><th scope="col">Option</th><th scope="col">Delivery time</th><th scope="col">Charge</th></tr>
              </thead>
              <tbody>
                <tr><th scope="row">Standard Delivery</th><td>5 – 7 business days</td><td><strong>Free</strong> on orders of ₹1,999 or more<br>₹99 on orders below ₹1,999</td></tr>
                <tr><th scope="row">Express Delivery</th><td>2 – 3 business days</td><td>₹250</td></tr>
              </tbody>
            </table>
          </div>
          <p>The free shipping threshold applies to your order total after any coupon discount. Shipping charges are always shown at checkout before you pay.</p>
        </section>

        <section id="processing">
          <h2><span>3.</span> Order Processing</h2>
          <ul>
            <li>Orders are usually packed and dispatched within <strong>1–2 business days</strong> of confirmation.</li>
            <li>Orders placed on Sundays or public holidays are processed on the next business day.</li>
            <li>Cash on Delivery orders may be confirmed by phone before dispatch.</li>
            <li>Items needing alterations, blouse stitching or customisation take longer. We will let you know the expected time when you order.</li>
          </ul>
        </section>

        <section id="delivery-times">
          <h2><span>4.</span> Delivery Times</h2>
          <p>Delivery times are counted from dispatch and are estimates. Most orders arrive within the times above, but deliveries to remote areas may take a few extra days.</p>
          <p>During festive seasons, sales, bad weather or other events outside our control, couriers may take longer. We will do our best to keep you informed of any delays.</p>
        </section>

        <section id="tracking">
          <h2><span>5.</span> Tracking Your Order</h2>
          <p>Once your order is dispatched, we will send you an email with your tracking number and a link to follow your parcel. You can also check its progress any time on our <a href="track-order">Track Your Order</a> page.</p>
        </section>

        <section id="address">
          <h2><span>6.</span> Delivery Address</h2>
          <ul>
            <li>Please check your delivery address, PIN code and phone number carefully before placing your order.</li>
            <li>To change your address, contact us as soon as possible. We can only update it before the order is dispatched.</li>
            <li>We are not responsible for delays or lost parcels caused by an incorrect or incomplete address.</li>
          </ul>
        </section>

        <section id="receiving">
          <h2><span>7.</span> Receiving Your Order</h2>
          <p>Our courier partners may ask for a one-time password (OTP) or signature on delivery. Please check that the package is sealed and undamaged before accepting it. If the outer packaging looks tampered with or damaged, you may refuse the delivery and let us know straight away.</p>
          <p>We recommend recording a short video while opening your parcel. It helps us resolve any issue quickly.</p>
        </section>

        <section id="failed">
          <h2><span>8.</span> Failed Deliveries</h2>
          <p>If our courier cannot deliver your order, they will usually try again up to <strong>2 more times</strong>. If delivery still fails, the parcel is returned to us. In that case:</p>
          <ul>
            <li>For prepaid orders, we will contact you to arrange redelivery (extra shipping may apply) or refund the order minus shipping charges.</li>
            <li>For Cash on Delivery orders, the order will be cancelled.</li>
          </ul>
        </section>

        <section id="damaged">
          <h2><span>9.</span> Damaged or Missing Items</h2>
          <p>If your order arrives damaged, is missing an item or you received the wrong product, please contact us within <strong>48 hours</strong> of delivery with your order number and photos or video of the package and product. We will arrange a replacement or refund at no extra cost.</p>
        </section>

        <section id="international">
          <h2><span>10.</span> International Shipping</h2>
          <p>We currently ship within India only. If you would like to order from outside India, please contact us and we will let you know if we can help.</p>
        </section>

        <section id="contact">
          <h2><span>11.</span> Contact Us</h2>
          <p>For any questions about shipping or your delivery, please get in touch with your order number:</p>
          <dl class="policy__contact">
            <div><dt>Email</dt><dd><a href="mailto:info@mightysilks.ae">info@mightysilks.ae</a></dd></div>
            <div><dt>Phone</dt><dd>Toll Free: 800644489</dd></div>
            <div><dt>Address</dt><dd>Office #816 - 8th Floor, The Burlington Tower, Marasi Drive, Business Bay, Dubai, UAE</dd></div>
          </dl>
        </section>
      </article>
    </div>

  </main>
@endsection
