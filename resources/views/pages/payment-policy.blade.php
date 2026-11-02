@extends('layouts.site')

@section('title', 'Mighty Silks — Payment Policy')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Payment Policy</h1>
    </div>

    <!-- ============ Payment policy ============ -->
    <!-- No Figma frame for this page: the Privacy Policy's layout (a contents list that stays in
         view beside the text). js/main.js marks the section being read in the list. -->
    <div class="policy" data-policy>
      <aside class="policy__toc" aria-labelledby="policy-toc-title">
        <p class="policy__toc-title" id="policy-toc-title">Contents</p>
        <ol class="policy__toc-list">
          <li><a href="#overview">Overview</a></li>
          <li><a href="#methods">Accepted Payment Methods</a></li>
          <li><a href="#currency">Currency &amp; Pricing</a></li>
          <li><a href="#security">Payment Security</a></li>
          <li><a href="#cod">Cash on Delivery</a></li>
          <li><a href="#coupons">Coupons &amp; Discounts</a></li>
          <li><a href="#failed">Failed or Declined Payments</a></li>
          <li><a href="#confirmation">Order Confirmation</a></li>
          <li><a href="#refunds">Refunds</a></li>
          <li><a href="#cancellations">Cancellations</a></li>
          <li><a href="#fraud">Fraud Prevention</a></li>
          <li><a href="#contact">Contact Us</a></li>
        </ol>
      </aside>

      <article class="policy__body">
        <p class="policy__updated">Last updated: <time datetime="2026-10-29">29 October 2026</time></p>
        <p class="policy__lead">We want paying for your Mighty Silks order to be simple and secure. This policy explains the payment options we offer, how your payment is protected and how refunds work.</p>

        <section id="overview">
          <h2><span>1.</span> Overview</h2>
          <p>This Payment Policy applies to all orders placed on the Mighty Silks website. It should be read together with our <a href="terms-and-conditions">Terms &amp; Conditions</a> and <a href="privacy-policy">Privacy Policy</a>.</p>
        </section>

        <section id="methods">
          <h2><span>2.</span> Accepted Payment Methods</h2>
          <p>You can choose any of the following at checkout:</p>
          <ul>
            <li><strong>UPI:</strong> Google Pay, PhonePe, Paytm and other UPI apps.</li>
            <li><strong>Credit and debit cards:</strong> Visa, Mastercard and RuPay.</li>
            <li><strong>Cash on Delivery (COD):</strong> pay when your order arrives, where available.</li>
          </ul>
          <p>The payment methods available may vary depending on your order value and delivery location.</p>
        </section>

        <section id="currency">
          <h2><span>3.</span> Currency &amp; Pricing</h2>
          <ul>
            <li>All prices are shown and charged in Indian Rupees (₹) and include applicable taxes unless stated otherwise.</li>
            <li>Shipping charges, such as Express Delivery, are shown at checkout before you pay. Standard shipping is free on orders above ₹1,999.</li>
            <li>If your card is issued outside India, your bank may apply currency conversion or international transaction fees. These are set by your bank, not by us.</li>
          </ul>
        </section>

        <section id="security">
          <h2><span>4.</span> Payment Security</h2>
          <p>Your payment details are protected at every step:</p>
          <ul>
            <li>Payments are processed by secure, certified payment gateways.</li>
            <li>All payment information is encrypted during transmission.</li>
            <li>We never store your full card number, CVV or UPI PIN on our systems.</li>
            <li>Card payments may require extra verification, such as a one-time password (OTP) from your bank.</li>
          </ul>
          <p>Mighty Silks will never ask for your card PIN, CVV or OTP by phone, email or message. If anyone contacts you asking for these details, please do not share them and let us know.</p>
        </section>

        <section id="cod">
          <h2><span>5.</span> Cash on Delivery</h2>
          <ul>
            <li>COD is available for eligible orders and delivery locations, and may have an upper order value limit.</li>
            <li>Please keep the exact amount ready, as delivery partners may not carry change.</li>
            <li>We may ask you to confirm COD orders by phone before dispatch.</li>
            <li>Repeatedly refusing COD orders on delivery may lead to COD being unavailable on future orders.</li>
          </ul>
        </section>

        <section id="coupons">
          <h2><span>6.</span> Coupons &amp; Discounts</h2>
          <p>Coupon codes, such as our <strong>NEW10</strong> welcome offer, are applied in your cart or at checkout and the discount is shown before you pay. Unless stated otherwise, one coupon can be used per order. Coupons have no cash value and cannot be applied after an order has been placed.</p>
        </section>

        <section id="failed">
          <h2><span>7.</span> Failed or Declined Payments</h2>
          <p>A payment may fail because of incorrect details, insufficient funds, bank limits or a network problem. If this happens, your order will not be placed and you can try again or choose another payment method.</p>
          <p>If money was debited from your account but your order was not confirmed, the amount is usually reversed automatically by your bank or payment provider within <strong>5–7 business days</strong>. If it is not, please contact us with your transaction details.</p>
        </section>

        <section id="confirmation">
          <h2><span>8.</span> Order Confirmation</h2>
          <p>Once your payment is successful, you will see your order confirmation and receive it by email. Please keep your order number for any questions about your order or payment.</p>
        </section>

        <section id="refunds">
          <h2><span>9.</span> Refunds</h2>
          <p>When a refund is approved, for example after a return, a cancelled order or an unavailable item:</p>
          <ul>
            <li><strong>UPI and card payments</strong> are refunded to the original payment method.</li>
            <li><strong>Cash on Delivery orders</strong> are refunded by bank transfer or UPI to an account you provide.</li>
            <li>Refunds are usually processed within <strong>5–10 business days</strong> of approval. The time it takes to show in your account depends on your bank.</li>
          </ul>
          <p>Shipping charges are refunded only if the return is due to our error, such as a damaged or incorrect item.</p>
        </section>

        <section id="cancellations">
          <h2><span>10.</span> Cancellations</h2>
          <p>You can cancel an order before it is dispatched by contacting us. If you have already paid, you will receive a full refund to your original payment method. Orders that have already been dispatched cannot be cancelled but may be returned under our returns terms.</p>
        </section>

        <section id="fraud">
          <h2><span>11.</span> Fraud Prevention</h2>
          <p>To protect our customers, we may review orders for signs of fraud. We may hold, verify or cancel an order if a payment looks suspicious, and any amount paid for a cancelled order will be refunded.</p>
        </section>

        <section id="contact">
          <h2><span>12.</span> Contact Us</h2>
          <p>For any questions about payments or refunds, please get in touch with your order number:</p>
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
