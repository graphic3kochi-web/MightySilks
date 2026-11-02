@extends('layouts.site')

@section('title', 'Mighty Silks — My Cart')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">My Cart</h1>
    </div>

    <!-- ============ Cart (Figma 281:2755 – 281:2856) ============ -->
    <!-- js/main.js renders the rows from the saved cart (the four sarees below are the design's,
         shown when the script doesn't run) and keeps the subtotal in step. -->
    <section class="cart-page" aria-label="Cart" data-cart-page>
      <div class="cart-table" data-cart-page-table>
        <div class="cart-table__head" aria-hidden="true">
          <span>Product</span><span>Price</span><span>Quantity</span><span>Total</span><span></span>
        </div>
        <ul class="cart-table__rows" data-cart-page-rows>
          <li class="cart-row">
            <div class="cart-row__product">
              <span class="cart-row__photo"><img src="assets/cart/item-1.png" alt=""></span>
              <p class="cart-row__name">Semi Silk Peacock Blue Saree with Silver Zari Woven Pallu and Green Zari Border</p>
            </div>
            <p class="cart-row__price"><span class="cart-row__label">Price</span>₹ 2,480.00</p>
            <div class="cart-row__qty">
              <button type="button" aria-label="Decrease quantity" disabled><img src="assets/cart/minus.svg" alt=""></button>
              <span aria-label="Quantity">1</span>
              <button type="button" aria-label="Increase quantity"><img src="assets/cart/plus.svg" alt=""></button>
            </div>
            <p class="cart-row__total">₹ 2,480.00</p>
            <button class="cart-row__remove" type="button" aria-label="Remove item"><img src="assets/cart/delete.svg" alt=""></button>
            <img class="cart-row__rule" src="assets/cart/row-rule.svg" alt="">
          </li>
          <li class="cart-row">
            <div class="cart-row__product">
              <span class="cart-row__photo"><img src="assets/cart/item-2.png" alt=""></span>
              <p class="cart-row__name">Semi Silk Sea Green Golden Zari Pallu Saree with Paisley Butta Body and Teal Border</p>
            </div>
            <p class="cart-row__price"><span class="cart-row__label">Price</span>₹ 2,480.00</p>
            <div class="cart-row__qty">
              <button type="button" aria-label="Decrease quantity" disabled><img src="assets/cart/minus.svg" alt=""></button>
              <span aria-label="Quantity">1</span>
              <button type="button" aria-label="Increase quantity"><img src="assets/cart/plus.svg" alt=""></button>
            </div>
            <p class="cart-row__total">₹ 2,480.00</p>
            <button class="cart-row__remove" type="button" aria-label="Remove item"><img src="assets/cart/delete.svg" alt=""></button>
            <img class="cart-row__rule" src="assets/cart/row-rule.svg" alt="">
          </li>
          <li class="cart-row">
            <div class="cart-row__product">
              <span class="cart-row__photo"><img src="assets/cart/item-3.png" alt=""></span>
              <p class="cart-row__name">Organza Cream Watercolor Pink Floral Printed Saree with Stone Studded Scalloped Border</p>
            </div>
            <p class="cart-row__price"><span class="cart-row__label">Price</span>₹ 3,330.00</p>
            <div class="cart-row__qty">
              <button type="button" aria-label="Decrease quantity" disabled><img src="assets/cart/minus.svg" alt=""></button>
              <span aria-label="Quantity">1</span>
              <button type="button" aria-label="Increase quantity"><img src="assets/cart/plus.svg" alt=""></button>
            </div>
            <p class="cart-row__total">₹ 3,330.00</p>
            <button class="cart-row__remove" type="button" aria-label="Remove item"><img src="assets/cart/delete.svg" alt=""></button>
            <img class="cart-row__rule" src="assets/cart/row-rule.svg" alt="">
          </li>
          <li class="cart-row">
            <div class="cart-row__product">
              <span class="cart-row__photo"><img src="assets/cart/item-4.png" alt=""></span>
              <p class="cart-row__name">Organza Cream Teal Blue and Olive Golden Wavy Stripe Printed Saree with Beaded Scalloped Border</p>
            </div>
            <p class="cart-row__price"><span class="cart-row__label">Price</span>₹ 3,330.00</p>
            <div class="cart-row__qty">
              <button type="button" aria-label="Decrease quantity" disabled><img src="assets/cart/minus.svg" alt=""></button>
              <span aria-label="Quantity">1</span>
              <button type="button" aria-label="Increase quantity"><img src="assets/cart/plus.svg" alt=""></button>
            </div>
            <p class="cart-row__total">₹ 3,330.00</p>
            <button class="cart-row__remove" type="button" aria-label="Remove item"><img src="assets/cart/delete.svg" alt=""></button>
            <img class="cart-row__rule" src="assets/cart/row-rule.svg" alt="">
          </li>
        </ul>

        <div class="cart-summary">
          <p class="cart-summary__subtotal">Subtotal: <strong data-cart-page-subtotal>₹ 11,620.00</strong></p>
          <p class="cart-summary__tax">Tax included. <a href="#">Shipping</a> calculated at checkout.</p>
          <a class="pdp-btn pdp-btn--solid cart-summary__checkout" href="checkout.html">Go to Check Out</a>
        </div>
      </div>

      <div class="cart-page__empty" data-cart-page-empty hidden>
        <p>Your cart is empty.</p>
        <a class="pdp-btn pdp-btn--solid" href="our-shop.html">Continue Shopping</a>
      </div>
    </section>

  </main>
@endsection
