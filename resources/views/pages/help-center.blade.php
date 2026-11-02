@extends('layouts.site')

@section('title', 'Mighty Silks — Help Center')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Help center ============ -->
    <!-- No Figma frame for this page. js/main.js filters the FAQs by the search box and the topic
         cards together; the answers match the policy pages. -->

    <!-- Hero: title and FAQ search on the grey band. -->
    <section class="help-hero">
      <h1 class="help-hero__title">How can we help?</h1>
      <p class="help-hero__lead">Search our frequently asked questions or browse by topic.</p>
      <form class="help-search" role="search" data-help-search>
        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
        <label class="visually-hidden" for="help-query">Search help articles</label>
        <input id="help-query" type="search" name="q" placeholder="e.g. track my order, return, COD" autocomplete="off" data-help-query>
      </form>
    </section>

    <!-- Topics: cards that show one category of FAQs (All shows every one). -->
    <section class="help-topics" aria-labelledby="help-topics-title">
      <h2 class="visually-hidden" id="help-topics-title">Browse by topic</h2>
      <div class="help-topics__grid" role="group" aria-label="Filter questions by topic" data-help-topics>
        <button class="help-topic" type="button" aria-pressed="false" data-help-topic="orders">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2z"/><path d="M9 8h6M9 12h6"/></svg>
          <span class="help-topic__name">Orders &amp; Tracking</span>
          <span class="help-topic__desc">Placing, changing and tracking orders</span>
        </button>
        <button class="help-topic" type="button" aria-pressed="false" data-help-topic="shipping">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h11v9H3zM14 10h4l3 3v3h-7"/><circle cx="7" cy="17.5" r="1.8"/><circle cx="17" cy="17.5" r="1.8"/></svg>
          <span class="help-topic__name">Shipping &amp; Delivery</span>
          <span class="help-topic__desc">Charges, delivery times and addresses</span>
        </button>
        <button class="help-topic" type="button" aria-pressed="false" data-help-topic="returns">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9h11a5 5 0 0 1 0 10H9"/><path d="M8 5L4 9l4 4"/></svg>
          <span class="help-topic__name">Returns &amp; Exchanges</span>
          <span class="help-topic__desc">7-day returns, exchanges and pickups</span>
        </button>
        <button class="help-topic" type="button" aria-pressed="false" data-help-topic="payments">
          <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18M7 15h4"/></svg>
          <span class="help-topic__name">Payments &amp; Refunds</span>
          <span class="help-topic__desc">UPI, cards, COD and refund timelines</span>
        </button>
        <button class="help-topic" type="button" aria-pressed="false" data-help-topic="account">
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg>
          <span class="help-topic__name">Account &amp; Login</span>
          <span class="help-topic__desc">Signing in, passwords and your details</span>
        </button>
        <button class="help-topic" type="button" aria-pressed="false" data-help-topic="products">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l2.6 5.3 5.9.9-4.3 4.1 1 5.8L12 16.4 6.8 19.1l1-5.8-4.3-4.1 5.9-.9z"/></svg>
          <span class="help-topic__name">Products &amp; Care</span>
          <span class="help-topic__desc">Fabrics, blouses and caring for silk</span>
        </button>
      </div>
    </section>

    <!-- FAQs: grouped by topic, each question opens to its answer. -->
    <section class="help-faqs" aria-labelledby="help-faqs-title">
      <div class="help-faqs__head">
        <h2 class="help-faqs__title" id="help-faqs-title">Frequently Asked Questions</h2>
        <button class="help-faqs__clear" type="button" data-help-clear hidden>Show all questions</button>
      </div>

      <div class="help-group" data-help-group="orders">
        <h3 class="help-group__title">Orders &amp; Tracking</h3>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">How do I place an order?</span></summary><div class="careers-job__body"><p>Browse our collections, choose your item and click <strong>Add to Cart</strong> or <strong>Buy Now</strong>. Open your cart, select <strong>Checkout</strong>, enter your contact and delivery details, choose a shipping and payment method, and place your order. You'll see a confirmation straight away.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">How can I track my order?</span></summary><div class="careers-job__body"><p>Once your order is dispatched, we'll email you a tracking number and link. You can also follow your order's progress on our <a href="track-order.html">Track Your Order</a> page.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Can I change or cancel my order?</span></summary><div class="careers-job__body"><p>Yes, as long as it hasn't been dispatched. Contact us as soon as possible with your order number. Cancellations before dispatch are free and fully refunded. Once dispatched, an order can't be cancelled, but you can return it after delivery.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">I didn't receive an order confirmation. What should I do?</span></summary><div class="careers-job__body"><p>Please check your spam or promotions folder first. If you still can't find it, contact us with the email address or phone number you used, and we'll confirm your order.</p></div></details>
      </div>

      <div class="help-group" data-help-group="shipping">
        <h3 class="help-group__title">Shipping &amp; Delivery</h3>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">How much does shipping cost?</span></summary><div class="careers-job__body"><p>Standard Delivery is <strong>free</strong> on orders of ₹1,999 or more (after any coupon), and ₹99 below that. Express Delivery costs ₹250. See our <a href="shipping-policy.html">Shipping Policy</a> for details.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">How long will delivery take?</span></summary><div class="careers-job__body"><p>Orders are dispatched within 1–2 business days. Standard Delivery then takes 5–7 business days and Express Delivery 2–3 business days. Remote areas and festive seasons may take a little longer.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Do you ship outside India?</span></summary><div class="careers-job__body"><p>We currently ship within India only. If you'd like to order from abroad, please contact us and we'll let you know if we can help.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Can I change my delivery address?</span></summary><div class="careers-job__body"><p>Yes, before your order is dispatched. Contact us with your order number and the new address as soon as possible.</p></div></details>
      </div>

      <div class="help-group" data-help-group="returns">
        <h3 class="help-group__title">Returns &amp; Exchanges</h3>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">What is your return policy?</span></summary><div class="careers-job__body"><p>You can return or exchange eligible items within <strong>7 days</strong> of delivery. Items must be unused, unwashed and in their original packaging with all tags attached. Read the full <a href="return-policy.html">Return Policy</a>.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">How do I request a return or exchange?</span></summary><div class="careers-job__body"><p>Contact us within 7 days of delivery with your order number, the item and the reason. Once approved, we'll arrange a pickup or share the address to send it to.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Which items can't be returned?</span></summary><div class="careers-job__body"><p>Customised or altered items, sarees with stitched blouses or fall and pico work done at your request, clearance sale items and gift cards can't be returned unless they arrive damaged or incorrect.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">My item arrived damaged or wrong. What do I do?</span></summary><div class="careers-job__body"><p>We're sorry! Please contact us within <strong>48 hours</strong> of delivery with your order number and photos or an unboxing video. We'll arrange a free pickup and send a replacement or a full refund.</p></div></details>
      </div>

      <div class="help-group" data-help-group="payments">
        <h3 class="help-group__title">Payments &amp; Refunds</h3>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Which payment methods do you accept?</span></summary><div class="careers-job__body"><p>UPI (Google Pay, PhonePe, Paytm and more), credit and debit cards (Visa, Mastercard, RuPay) and Cash on Delivery where available. See our <a href="payment-policy.html">Payment Policy</a>.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Is Cash on Delivery available?</span></summary><div class="careers-job__body"><p>Yes, for eligible orders and delivery locations. Choose <strong>Cash on Delivery</strong> at checkout and keep the exact amount ready when your order arrives.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Money was deducted but my order failed. What now?</span></summary><div class="careers-job__body"><p>Don't worry. Your bank or payment provider usually reverses the amount automatically within 5–7 business days. If it doesn't, contact us with your transaction details.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">When will I get my refund?</span></summary><div class="careers-job__body"><p>Approved refunds are processed within <strong>5–10 business days</strong> to your original payment method. Cash on Delivery orders are refunded by bank transfer or UPI.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">How do I use a coupon code?</span></summary><div class="careers-job__body"><p>Enter your code, such as <strong>NEW10</strong>, in your cart or at checkout and click <strong>Apply</strong>. The discount is shown before you pay. One coupon can be used per order.</p></div></details>
      </div>

      <div class="help-group" data-help-group="account">
        <h3 class="help-group__title">Account &amp; Login</h3>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Do I need an account to shop?</span></summary><div class="careers-job__body"><p>No, you can check out as a guest. An account makes checkout faster and lets you see your orders and wishlist in one place. <a href="signup.html">Create an account</a>.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Can I log in with my phone number?</span></summary><div class="careers-job__body"><p>Yes. On the <a href="login.html">Log In</a> page, choose <strong>Phone Number</strong>, enter your number and we'll send you a one-time code to sign in.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">I forgot my password. What should I do?</span></summary><div class="careers-job__body"><p>Click <strong>Forgot password?</strong> on the Log In page to reset it, or log in with your phone number and a one-time code instead.</p></div></details>
      </div>

      <div class="help-group" data-help-group="products">
        <h3 class="help-group__title">Products &amp; Care</h3>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Does my saree come with a blouse piece?</span></summary><div class="careers-job__body"><p>Most of our sarees include an unstitched blouse piece. Please check the product description, which says whether a blouse is included.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">Why does the colour look slightly different from the photo?</span></summary><div class="careers-job__body"><p>Screen settings and lighting can change how colours appear, and silk and zari shine differently in different light. Handwoven pieces may also have slight natural variations, which make each one unique.</p></div></details>
        <details class="careers-job help-faq"><summary><span class="careers-job__title">How should I care for my silk saree?</span></summary><div class="careers-job__body"><ul><li>Dry clean only, especially for the first few washes.</li><li>Store it folded in a cotton or muslin cloth, away from direct sunlight.</li><li>Refold it every few months to prevent creases from setting in the zari.</li><li>Iron on a low setting with a cloth between the iron and the fabric.</li></ul></div></details>
      </div>

      <p class="help-faqs__empty" data-help-empty hidden>No questions match your search. Try different words, or contact us below.</p>
    </section>

    <!-- Contact: three ways to reach the team. -->
    <section class="help-contact" aria-labelledby="help-contact-title">
      <p class="about-eyebrow">Still Need Help?</p>
      <h2 class="about-heading" id="help-contact-title">Contact Our Team</h2>
      <div class="help-contact__grid">
        <a class="help-contact__card" href="tel:800644489">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg>
          <span class="help-contact__name">Call Us</span>
          <span class="help-contact__detail">Toll Free: 800644489</span>
          <span class="help-contact__detail">+971 54 586 4310</span>
        </a>
        <a class="help-contact__card" href="mailto:info@mightysilks.ae">
          <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
          <span class="help-contact__name">Email Us</span>
          <span class="help-contact__detail">info@mightysilks.ae</span>
          <span class="help-contact__detail">Include your order number if you have one</span>
        </a>
        <a class="help-contact__card" href="about.html">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7-6.2-7-12a7 7 0 0 1 14 0c0 5.8-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>
          <span class="help-contact__name">Visit Us</span>
          <span class="help-contact__detail">The Burlington Tower, Business Bay</span>
          <span class="help-contact__detail">Dubai, UAE</span>
        </a>
      </div>
    </section>

  </main>
@endsection
