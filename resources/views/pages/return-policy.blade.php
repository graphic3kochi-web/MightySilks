@extends('layouts.site')

@section('title', 'Mighty Silks — Return Policy')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Return Policy</h1>
    </div>

    <!-- ============ Return policy ============ -->
    <!-- No Figma frame for this page: the Privacy Policy's layout (a contents list that stays in
         view beside the text). js/main.js marks the section being read in the list. The terms
         match the Terms, Payment and Shipping policies. -->
    <div class="policy" data-policy>
      <aside class="policy__toc" aria-labelledby="policy-toc-title">
        <p class="policy__toc-title" id="policy-toc-title">Contents</p>
        <ol class="policy__toc-list">
          <li><a href="#overview">Overview</a></li>
          <li><a href="#window">Return Window</a></li>
          <li><a href="#eligibility">Eligibility Conditions</a></li>
          <li><a href="#non-returnable">Non-Returnable Items</a></li>
          <li><a href="#damaged">Damaged or Wrong Items</a></li>
          <li><a href="#how-to-return">How to Request a Return</a></li>
          <li><a href="#pickup">Return Pickup &amp; Shipping</a></li>
          <li><a href="#quality-check">Quality Check</a></li>
          <li><a href="#refunds">Refunds</a></li>
          <li><a href="#exchanges">Exchanges</a></li>
          <li><a href="#cancellations">Cancellations</a></li>
          <li><a href="#contact">Contact Us</a></li>
        </ol>
      </aside>

      <article class="policy__body">
        <p class="policy__updated">Last updated: <time datetime="2026-10-29">29 October 2026</time></p>
        <p class="policy__lead">We want you to love every piece you buy from Mighty Silks. If something isn't right, our easy 7-day return policy lets you return or exchange it. Here's everything you need to know.</p>

        <section id="overview">
          <h2><span>1.</span> Overview</h2>
          <p>This Return Policy applies to products bought on the Mighty Silks website. It should be read together with our <a href="terms-and-conditions">Terms &amp; Conditions</a>, <a href="shipping-policy">Shipping Policy</a> and <a href="payment-policy">Payment Policy</a>.</p>
        </section>

        <section id="window">
          <h2><span>2.</span> Return Window</h2>
          <p>You can request a return or exchange within <strong>7 days</strong> of the date your order was delivered. Requests made after 7 days cannot be accepted, except for damaged or wrong items reported as explained below.</p>
        </section>

        <section id="eligibility">
          <h2><span>3.</span> Eligibility Conditions</h2>
          <p>To be eligible for a return or exchange, the product must be:</p>
          <ul>
            <li>Unused, unworn, unwashed and not altered in any way.</li>
            <li>In its original condition, with all tags, labels and the blouse piece (if supplied) attached.</li>
            <li>Returned in its original packaging, including any box, cover or pouch.</li>
            <li>Free of perfume, makeup, stains or other marks.</li>
          </ul>
          <p>Returns that do not meet these conditions may be refused and sent back to you.</p>
        </section>

        <section id="non-returnable">
          <h2><span>4.</span> Non-Returnable Items</h2>
          <p>For hygiene and because they are made specially for you, the following cannot be returned or exchanged, unless they arrive damaged or incorrect:</p>
          <ul>
            <li>Customised, altered or made-to-measure products.</li>
            <li>Sarees with stitched blouses or fall and pico work done at your request.</li>
            <li>Products bought during clearance sales or marked "non-returnable".</li>
            <li>Gift cards.</li>
          </ul>
        </section>

        <section id="damaged">
          <h2><span>5.</span> Damaged or Wrong Items</h2>
          <p>If your order arrives damaged, defective or different from what you ordered, please contact us within <strong>48 hours</strong> of delivery with your order number and clear photos or an unboxing video. We will arrange a free pickup and send you a replacement or a full refund, including any shipping charges.</p>
          <p>Please note that slight variations in weave, colour or motif are a natural part of handcrafted textiles and are not considered defects.</p>
        </section>

        <section id="how-to-return">
          <h2><span>6.</span> How to Request a Return</h2>
          <ol class="policy__steps">
            <li><strong>Contact us</strong> within 7 days of delivery by email or phone with your order number, the item you want to return and the reason.</li>
            <li><strong>Get approval.</strong> Our team will confirm whether the item is eligible and share return instructions.</li>
            <li><strong>Pack the item</strong> securely in its original packaging with all tags attached.</li>
            <li><strong>Hand it over</strong> to our courier partner at pickup, or ship it to us if pickup isn't available in your area.</li>
            <li><strong>Get your refund or exchange</strong> once the item passes our quality check.</li>
          </ol>
        </section>

        <section id="pickup">
          <h2><span>7.</span> Return Pickup &amp; Shipping</h2>
          <ul>
            <li>We offer reverse pickup for most PIN codes across India. We will confirm this when you request a return.</li>
            <li>If pickup is not available, please send the item to the address we provide using a trackable courier. We will reimburse reasonable shipping costs for damaged or wrong items.</li>
            <li>Please keep your courier receipt until your return is processed.</li>
          </ul>
        </section>

        <section id="quality-check">
          <h2><span>8.</span> Quality Check</h2>
          <p>Once we receive your return, our team inspects it within <strong>2–3 business days</strong> to make sure it meets the eligibility conditions. We will email you to let you know whether your return has been approved.</p>
        </section>

        <section id="refunds">
          <h2><span>9.</span> Refunds</h2>
          <ul>
            <li><strong>UPI and card payments</strong> are refunded to your original payment method.</li>
            <li><strong>Cash on Delivery orders</strong> are refunded by bank transfer or UPI to an account you provide.</li>
            <li>Refunds are processed within <strong>5–10 business days</strong> of approval. The time it takes to appear in your account depends on your bank.</li>
            <li>Original shipping charges are not refunded, unless the return is because of a damaged or wrong item.</li>
            <li>If you used a coupon, the refund is for the amount you actually paid.</li>
          </ul>
        </section>

        <section id="exchanges">
          <h2><span>10.</span> Exchanges</h2>
          <p>You can exchange an eligible item for a different colour, size or design of equal or higher value, subject to availability. If the new item costs more, you pay the difference. If the item you want is out of stock, we will refund you instead. Each order can be exchanged once.</p>
        </section>

        <section id="cancellations">
          <h2><span>11.</span> Cancellations</h2>
          <p>You can cancel an order free of charge before it is dispatched by contacting us. Once an order has been dispatched, it cannot be cancelled, but you may return it under this policy after delivery.</p>
        </section>

        <section id="contact">
          <h2><span>12.</span> Contact Us</h2>
          <p>To request a return or exchange, or for any questions, please get in touch with your order number:</p>
          <dl class="policy__contact">
            <div><dt>Email</dt><dd><a href="mailto:info@mightysilks.ae?subject=Return%20Request">info@mightysilks.ae</a></dd></div>
            <div><dt>Phone</dt><dd>Toll Free: 800644489</dd></div>
            <div><dt>Address</dt><dd>Office #816 - 8th Floor, The Burlington Tower, Marasi Drive, Business Bay, Dubai, UAE</dd></div>
          </dl>
        </section>
      </article>
    </div>

  </main>
@endsection
