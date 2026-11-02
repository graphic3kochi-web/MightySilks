@extends('layouts.site')

@section('title', 'Mighty Silks — Disclaimer Policy')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Disclaimer Policy</h1>
    </div>

    <!-- ============ Disclaimer ============ -->
    <!-- No Figma frame for this page: the Privacy Policy's layout (a contents list that stays in
         view beside the text). js/main.js marks the section being read in the list. -->
    <div class="policy" data-policy>
      <aside class="policy__toc" aria-labelledby="policy-toc-title">
        <p class="policy__toc-title" id="policy-toc-title">Contents</p>
        <ol class="policy__toc-list">
          <li><a href="#general">General Information</a></li>
          <li><a href="#images">Product Images &amp; Colours</a></li>
          <li><a href="#handcrafted">Handcrafted Products</a></li>
          <li><a href="#descriptions">Descriptions &amp; Availability</a></li>
          <li><a href="#pricing">Pricing &amp; Errors</a></li>
          <li><a href="#styling">Styling &amp; Blog Content</a></li>
          <li><a href="#reviews">Reviews &amp; Testimonials</a></li>
          <li><a href="#external-links">External Links</a></li>
          <li><a href="#liability">Limitation of Liability</a></li>
          <li><a href="#changes">Changes to This Disclaimer</a></li>
          <li><a href="#contact">Contact Us</a></li>
        </ol>
      </aside>

      <article class="policy__body">
        <p class="policy__updated">Last updated: <time datetime="2026-10-29">29 October 2026</time></p>
        <p class="policy__lead">The information on the Mighty Silks website is provided in good faith to help you discover and shop our collections. This disclaimer explains the limits of that information. Please read it alongside our <a href="terms-and-conditions.html">Terms &amp; Conditions</a> and <a href="privacy-policy.html">Privacy Policy</a>.</p>

        <section id="general">
          <h2><span>1.</span> General Information</h2>
          <p>All content on this website, including product details, prices, articles and images, is for general information and shopping purposes. While we work hard to keep it accurate and up to date, we make no guarantees about its completeness, accuracy or reliability, and it may change without notice.</p>
        </section>

        <section id="images">
          <h2><span>2.</span> Product Images &amp; Colours</h2>
          <p>We photograph our products carefully to show them as they really are. However, the colours you see may differ slightly from the actual product because of:</p>
          <ul>
            <li>Your screen's brightness, contrast and colour settings.</li>
            <li>Lighting conditions during photography.</li>
            <li>The natural sheen of silk and zari, which changes with the light.</li>
          </ul>
          <p>Models, jewellery, accessories and backgrounds in our photos are for styling only. Blouses and accessories are included only where the product description says so.</p>
        </section>

        <section id="handcrafted">
          <h2><span>3.</span> Handcrafted Products</h2>
          <p>Many of our sarees and garments are handwoven, hand-printed or hand-finished by skilled artisans. Slight irregularities in weave, colour, print or motif are a natural characteristic of handcrafted textiles. They make each piece unique and are not considered defects.</p>
        </section>

        <section id="descriptions">
          <h2><span>4.</span> Descriptions &amp; Availability</h2>
          <p>Product descriptions, fabric details, measurements and care instructions are provided as a guide. Measurements are approximate and may vary slightly. Products are subject to availability, and an item shown on the website may sell out before your order is processed.</p>
        </section>

        <section id="pricing">
          <h2><span>5.</span> Pricing &amp; Errors</h2>
          <p>We aim to show correct prices at all times. Occasionally, a price or offer may be shown incorrectly because of a technical or human error. In that case, we may cancel the affected order and refund any payment in full, as explained in our <a href="terms-and-conditions.html">Terms &amp; Conditions</a>.</p>
        </section>

        <section id="styling">
          <h2><span>6.</span> Styling &amp; Blog Content</h2>
          <p>Our blog, styling tips, trend guides and size suggestions are shared for inspiration and general guidance only. They reflect our team's opinions and may not suit every person or occasion. Information about textile traditions and festivals is shared in good faith but is not intended as expert or historical advice.</p>
        </section>

        <section id="reviews">
          <h2><span>7.</span> Reviews &amp; Testimonials</h2>
          <p>Customer reviews and testimonials reflect the personal experiences and opinions of the people who wrote them. They do not necessarily reflect the views of Mighty Silks, and your experience may differ.</p>
        </section>

        <section id="external-links">
          <h2><span>8.</span> External Links</h2>
          <p>Our website may link to other websites, such as social media platforms, payment providers and courier tracking pages. We do not control these websites and are not responsible for their content, availability or privacy practices. Visiting them is at your own risk.</p>
        </section>

        <section id="liability">
          <h2><span>9.</span> Limitation of Liability</h2>
          <p>To the extent permitted by law, Mighty Silks will not be liable for any loss or damage arising from your use of, or reliance on, the information on this website. This does not affect your rights as a consumer under applicable law.</p>
        </section>

        <section id="changes">
          <h2><span>10.</span> Changes to This Disclaimer</h2>
          <p>We may update this disclaimer from time to time. Any changes will be posted on this page with a new "Last updated" date.</p>
        </section>

        <section id="contact">
          <h2><span>11.</span> Contact Us</h2>
          <p>If you have any questions about this disclaimer, please get in touch:</p>
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
