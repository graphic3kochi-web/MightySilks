@extends('layouts.site')

@section('title', 'Mighty Silks — Terms & Conditions')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Terms &amp; Conditions</h1>
    </div>

    <!-- ============ Terms and conditions ============ -->
    <!-- No Figma frame for this page: the Privacy Policy's layout (a contents list that stays in
         view beside the text). js/main.js marks the section being read in the list. -->
    <div class="policy" data-policy>
      <aside class="policy__toc" aria-labelledby="policy-toc-title">
        <p class="policy__toc-title" id="policy-toc-title">Contents</p>
        <ol class="policy__toc-list">
          <li><a href="#acceptance">Acceptance of Terms</a></li>
          <li><a href="#using-our-website">Using Our Website</a></li>
          <li><a href="#products">Products &amp; Descriptions</a></li>
          <li><a href="#prices">Prices &amp; Payment</a></li>
          <li><a href="#orders">Orders</a></li>
          <li><a href="#shipping">Shipping &amp; Delivery</a></li>
          <li><a href="#returns">Returns &amp; Exchanges</a></li>
          <li><a href="#offers">Coupons &amp; Offers</a></li>
          <li><a href="#intellectual-property">Intellectual Property</a></li>
          <li><a href="#reviews">Reviews &amp; User Content</a></li>
          <li><a href="#liability">Limitation of Liability</a></li>
          <li><a href="#privacy">Privacy</a></li>
          <li><a href="#governing-law">Governing Law</a></li>
          <li><a href="#changes">Changes to These Terms</a></li>
          <li><a href="#contact">Contact Us</a></li>
        </ol>
      </aside>

      <article class="policy__body">
        <p class="policy__updated">Last updated: <time datetime="2026-10-29">29 October 2026</time></p>
        <p class="policy__lead">Welcome to Mighty Silks. These Terms &amp; Conditions explain the rules for using our website and buying from us. Please read them carefully before placing an order.</p>

        <section id="acceptance">
          <h2><span>1.</span> Acceptance of Terms</h2>
          <p>These terms apply to your use of the Mighty Silks website and online store (our "Website") and to every order you place with us. By using the Website or placing an order, you agree to these terms. If you do not agree, please do not use the Website.</p>
          <p>In these terms, "we", "us" and "our" mean Mighty Silks, and "you" means the person using the Website or buying from us.</p>
        </section>

        <section id="using-our-website">
          <h2><span>2.</span> Using Our Website</h2>
          <ul>
            <li>You must be at least 18 years old, or use the Website with the involvement of a parent or guardian.</li>
            <li>If you create an account, keep your password private. You are responsible for activity on your account.</li>
            <li>Please give us accurate, up-to-date information, including your contact and delivery details.</li>
            <li>You must not misuse the Website, for example by trying to access it without permission, interfering with how it works or using it for anything unlawful.</li>
          </ul>
          <p>We may suspend or close an account that breaks these terms.</p>
        </section>

        <section id="products">
          <h2><span>3.</span> Products &amp; Descriptions</h2>
          <p>We take care to show our products as accurately as possible. However:</p>
          <ul>
            <li>Colours may look slightly different on screen than in person, depending on your device and lighting.</li>
            <li>Many of our sarees are handwoven or hand-finished. Small variations in weave, colour or motif are a natural part of handcrafted textiles and are not defects.</li>
            <li>Measurements and weights are approximate.</li>
            <li>Jewellery and accessories shown in photos are for styling only and are not included unless stated.</li>
          </ul>
          <p>All products are subject to availability. If an item you order is no longer available, we will let you know and refund any payment for it.</p>
        </section>

        <section id="prices">
          <h2><span>4.</span> Prices &amp; Payment</h2>
          <ul>
            <li>Prices are shown in the currency displayed on the Website and include applicable taxes unless stated otherwise.</li>
            <li>Shipping charges, if any, are shown at checkout before you pay.</li>
            <li>We accept the payment methods shown at checkout, such as UPI, credit and debit cards, and cash on delivery where available.</li>
            <li>We may change prices at any time, but changes will not affect orders you have already placed.</li>
          </ul>
          <p>If a product is shown at an obviously incorrect price because of an error, we may cancel the order and refund you in full.</p>
        </section>

        <section id="orders">
          <h2><span>5.</span> Orders</h2>
          <p>When you place an order, you will receive an order confirmation. This confirms we have received your order; it does not mean it has been accepted. Your order is accepted when we dispatch it.</p>
          <p>We may refuse or cancel an order, for example if a product is unavailable, if there is a pricing error, or if we suspect fraud. If we cancel an order you have paid for, we will refund you in full.</p>
        </section>

        <section id="shipping">
          <h2><span>6.</span> Shipping &amp; Delivery</h2>
          <ul>
            <li>We offer free standard shipping on orders above ₹1,999 across India. Other shipping charges are shown at checkout.</li>
            <li>Delivery times shown are estimates. Delays can happen because of couriers, weather, festivals or customs.</li>
            <li>Please make sure your delivery address is correct. We are not responsible for delays or losses caused by an incorrect address.</li>
            <li>Risk in the products passes to you when they are delivered.</li>
          </ul>
        </section>

        <section id="returns">
          <h2><span>7.</span> Returns &amp; Exchanges</h2>
          <p>We want you to love what you buy. You may request a return or exchange within <strong>7 days</strong> of delivery, as long as:</p>
          <ul>
            <li>The product is unused, unwashed and in its original condition and packaging, with all tags attached.</li>
            <li>It is not a customised, altered or stitched-to-measure item, or a product marked as non-returnable.</li>
          </ul>
          <p>If you receive a damaged or incorrect item, please contact us within 48 hours of delivery with photos, and we will put it right. Approved refunds are made to your original payment method.</p>
        </section>

        <section id="offers">
          <h2><span>8.</span> Coupons &amp; Offers</h2>
          <p>Coupons and promotional offers, such as our <strong>NEW10</strong> welcome offer, are subject to their own conditions. Unless stated otherwise, only one coupon can be used per order, coupons cannot be exchanged for cash and offers may end at any time.</p>
        </section>

        <section id="intellectual-property">
          <h2><span>9.</span> Intellectual Property</h2>
          <p>All content on the Website, including our name, logo, photographs, designs and text, belongs to Mighty Silks or our partners and is protected by intellectual property laws. You may not copy, reproduce or use it for commercial purposes without our written permission.</p>
        </section>

        <section id="reviews">
          <h2><span>10.</span> Reviews &amp; User Content</h2>
          <p>If you post a review, photo or comment on our Website or social channels, you confirm it is your own and is honest and respectful. You allow us to use it to promote our products. We may remove content that is offensive, misleading or unlawful.</p>
        </section>

        <section id="liability">
          <h2><span>11.</span> Limitation of Liability</h2>
          <p>We provide the Website "as is" and do not promise it will always be available or error-free. To the extent permitted by law, we are not liable for indirect or consequential losses, and our total liability for any order is limited to the amount you paid for it.</p>
          <p>Nothing in these terms limits your rights as a consumer under applicable law.</p>
        </section>

        <section id="privacy">
          <h2><span>12.</span> Privacy</h2>
          <p>We handle your personal information as described in our <a href="privacy-policy">Privacy Policy</a>.</p>
        </section>

        <section id="governing-law">
          <h2><span>13.</span> Governing Law</h2>
          <p>These terms are governed by the laws of the United Arab Emirates as applied in the Emirate of Dubai. Any disputes will be subject to the jurisdiction of the courts of Dubai, unless the law where you live gives you the right to bring a claim in your local courts.</p>
        </section>

        <section id="changes">
          <h2><span>14.</span> Changes to These Terms</h2>
          <p>We may update these terms from time to time. The version on the Website when you place an order applies to that order. We will change the "Last updated" date at the top of this page when we make changes.</p>
        </section>

        <section id="contact">
          <h2><span>15.</span> Contact Us</h2>
          <p>If you have any questions about these Terms &amp; Conditions, please get in touch:</p>
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
