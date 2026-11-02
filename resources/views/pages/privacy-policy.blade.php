@extends('layouts.site')

@section('title', 'Mighty Silks — Privacy Policy')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Privacy Policy</h1>
    </div>

    <!-- ============ Privacy policy ============ -->
    <!-- No Figma frame for this page: a contents list that stays in view beside the policy text.
         js/main.js marks the section being read in the list. -->
    <div class="policy" data-policy>
      <aside class="policy__toc" aria-labelledby="policy-toc-title">
        <p class="policy__toc-title" id="policy-toc-title">Contents</p>
        <ol class="policy__toc-list">
          <li><a href="#introduction">Introduction</a></li>
          <li><a href="#information-we-collect">Information We Collect</a></li>
          <li><a href="#how-we-use">How We Use Your Information</a></li>
          <li><a href="#cookies">Cookies &amp; Similar Technologies</a></li>
          <li><a href="#sharing">Sharing Your Information</a></li>
          <li><a href="#payments">Payments</a></li>
          <li><a href="#retention">Data Retention</a></li>
          <li><a href="#security">Data Security</a></li>
          <li><a href="#your-rights">Your Rights</a></li>
          <li><a href="#children">Children's Privacy</a></li>
          <li><a href="#third-party">Third-Party Links</a></li>
          <li><a href="#changes">Changes to This Policy</a></li>
          <li><a href="#contact">Contact Us</a></li>
        </ol>
      </aside>

      <article class="policy__body">
        <p class="policy__updated">Last updated: <time datetime="2026-10-29">29 October 2026</time></p>
        <p class="policy__lead">At Mighty Silks, your privacy matters to us. This policy explains what personal information we collect when you visit our website or shop with us, how we use it, and the choices you have.</p>

        <section id="introduction">
          <h2><span>1.</span> Introduction</h2>
          <p>This Privacy Policy applies to the Mighty Silks website, our online store and our customer services (together, our "Services"). Mighty Silks is based at Office #816, 8th Floor, The Burlington Tower, Marasi Drive, Business Bay, Dubai, UAE.</p>
          <p>By using our Services, you agree to the collection and use of your information as described in this policy. If you do not agree, please do not use our Services.</p>
        </section>

        <section id="information-we-collect">
          <h2><span>2.</span> Information We Collect</h2>
          <p>We collect information you give us directly, and some information automatically when you use our website.</p>
          <h3>Information you give us</h3>
          <ul>
            <li><strong>Account details:</strong> your name, email address, phone number and password when you create an account.</li>
            <li><strong>Order details:</strong> your billing and delivery addresses, the items you buy and any order instructions.</li>
            <li><strong>Communications:</strong> messages you send us by email, phone, chat or our forms, including job applications and CVs.</li>
            <li><strong>Newsletter:</strong> your email address if you subscribe to our updates.</li>
          </ul>
          <h3>Information collected automatically</h3>
          <ul>
            <li>Your device, browser type and IP address.</li>
            <li>Pages you visit, products you view and how you use our website.</li>
            <li>Items saved in your cart or wishlist.</li>
          </ul>
        </section>

        <section id="how-we-use">
          <h2><span>3.</span> How We Use Your Information</h2>
          <p>We use your information to:</p>
          <ul>
            <li>Process and deliver your orders, and handle returns and exchanges.</li>
            <li>Manage your account and keep it secure.</li>
            <li>Respond to your questions and provide customer support.</li>
            <li>Send order updates and, if you agree, news about new collections and offers.</li>
            <li>Improve our website, products and services.</li>
            <li>Prevent fraud and meet our legal obligations.</li>
          </ul>
          <p>You can unsubscribe from marketing emails at any time using the link in each email.</p>
        </section>

        <section id="cookies">
          <h2><span>4.</span> Cookies &amp; Similar Technologies</h2>
          <p>We use cookies and similar technologies, such as browser storage, to keep items in your cart, remember your preferences and understand how our website is used.</p>
          <ul>
            <li><strong>Essential cookies</strong> make the website work, for example your cart and login.</li>
            <li><strong>Preference cookies</strong> remember choices such as your wishlist.</li>
            <li><strong>Analytics cookies</strong> help us understand which pages are popular so we can improve them.</li>
          </ul>
          <p>You can control or delete cookies in your browser settings. Blocking essential cookies may stop parts of the website, such as the cart, from working.</p>
        </section>

        <section id="sharing">
          <h2><span>5.</span> Sharing Your Information</h2>
          <p>We do not sell your personal information. We only share it with trusted parties who help us run our business, and only as much as they need:</p>
          <ul>
            <li><strong>Delivery partners</strong>, to ship your orders.</li>
            <li><strong>Payment providers</strong>, to process your payments securely.</li>
            <li><strong>Service providers</strong> for website hosting, email and analytics.</li>
            <li><strong>Authorities</strong>, when required by law or to protect our rights and customers.</li>
          </ul>
        </section>

        <section id="payments">
          <h2><span>6.</span> Payments</h2>
          <p>Payments are handled by secure, certified payment providers. We do not store your full card number or CVV on our systems. Your payment details are encrypted and sent directly to the payment provider.</p>
        </section>

        <section id="retention">
          <h2><span>7.</span> Data Retention</h2>
          <p>We keep your personal information only for as long as we need it for the purposes in this policy, for example to complete your orders, handle returns and warranties, and meet legal, tax and accounting requirements. When it is no longer needed, we delete or anonymise it.</p>
        </section>

        <section id="security">
          <h2><span>8.</span> Data Security</h2>
          <p>We use appropriate technical and organisational measures to protect your information, including encrypted connections and restricted access. No method of transmission over the internet is completely secure, but we work hard to keep your data safe. Please keep your account password private.</p>
        </section>

        <section id="your-rights">
          <h2><span>9.</span> Your Rights</h2>
          <p>Depending on the laws that apply to you, you may have the right to:</p>
          <ul>
            <li>Access the personal information we hold about you.</li>
            <li>Ask us to correct information that is wrong or incomplete.</li>
            <li>Ask us to delete your information.</li>
            <li>Object to or restrict how we use your information.</li>
            <li>Withdraw your consent to marketing at any time.</li>
          </ul>
          <p>To make a request, contact us using the details below. We may need to confirm your identity before we respond.</p>
        </section>

        <section id="children">
          <h2><span>10.</span> Children's Privacy</h2>
          <p>Our Services are not intended for children under 18. We do not knowingly collect personal information from children. If you believe a child has given us their information, please contact us and we will delete it.</p>
        </section>

        <section id="third-party">
          <h2><span>11.</span> Third-Party Links</h2>
          <p>Our website may link to other websites and social media, such as Instagram, Facebook and YouTube. We are not responsible for their privacy practices, so please read their privacy policies.</p>
        </section>

        <section id="changes">
          <h2><span>12.</span> Changes to This Policy</h2>
          <p>We may update this policy from time to time. When we do, we will change the "Last updated" date at the top of this page, and for important changes we may also let you know by email or a notice on our website.</p>
        </section>

        <section id="contact">
          <h2><span>13.</span> Contact Us</h2>
          <p>If you have any questions about this Privacy Policy or how we handle your information, please get in touch:</p>
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
