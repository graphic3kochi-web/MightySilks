@extends('layouts.site')

@section('title', 'Mighty Silks — Organza Cream Teal Wavy Stripe Saree')
@section('active', 'our-shop')

@section('scripts')
<script defer src="js/main.js"></script>
<script defer src="js/products.js"></script>
<script defer src="js/product.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (Figma 273:1602 / 273:1603) ============ -->
    <div class="shop-hero">
      <p class="shop-hero__title">Our Shop</p>
    </div>

    <!-- ============ Product (Figma 273:1937 – 273:2106) ============ -->
    <!-- js/product.js swaps the main photo when a thumbnail is chosen; js/main.js handles the
         Add to Cart / Buy Now ([data-add-to-cart]) and wishlist ([data-wishlist]) buttons. -->
    <section class="pdp" data-product>
      <div class="pdp__gallery" data-gallery>
        <div class="pdp__main">
          <img class="pdp__photo" src="assets/products/na-3a.png" alt="Organza cream teal blue and olive golden wavy stripe saree" style="--x:-2.896px;--y:0.316px;--w:762.977px;--h:1007.368px" data-gallery-main>
        </div>
        <div class="pdp__thumbs" role="group" aria-label="Product photos" data-gallery-thumbs>
          <button class="pdp__thumb is-active" type="button" aria-label="Photo 1" aria-pressed="true" data-full="assets/products/na-3a.png" data-x="-2.896px" data-y="0.316px" data-w="762.977px" data-h="1007.368px"><img src="assets/products/na-3a.png" alt="" style="--y:-5px;--w:148.949px;--h:196.66px"></button>
          <button class="pdp__thumb" type="button" aria-label="Photo 2" aria-pressed="false" data-full="assets/product-detail/thumb-2.png"><img src="assets/product-detail/thumb-2.png" alt="" style="--y:-5px;--w:150px;--h:199.023px"></button>
          <button class="pdp__thumb" type="button" aria-label="Photo 3" aria-pressed="false" data-full="assets/product-detail/thumb-3.png"><img src="assets/product-detail/thumb-3.png" alt="" style="--y:-5px;--w:150px;--h:200.977px"></button>
          <button class="pdp__thumb" type="button" aria-label="Photo 4" aria-pressed="false" data-full="assets/product-detail/thumb-4.png"><img src="assets/product-detail/thumb-4.png" alt="" style="--y:-5px;--w:150px;--h:200.977px"></button>
          <button class="pdp__thumb" type="button" aria-label="Photo 5" aria-pressed="false" data-full="assets/product-detail/thumb-5.png"><img src="assets/product-detail/thumb-5.png" alt="" style="--y:-5px;--w:150px;--h:200.977px"></button>
        </div>
      </div>

      <div class="pdp__info">
        <p class="pdp__sku" data-product-sku>SKU: K11521997</p>
        <h1 class="pdp__title" data-product-title>Organza Cream Teal Blue and Olive Golden Wavy Stripe Printed Saree with Beaded Scalloped Border</h1>
        <p class="pdp__price" data-product-price>₹ 3,330.00</p>
        <p class="pdp__tax">Tax included. <a href="#">Shipping</a> calculated at checkout.</p>

        <button class="pdp__wish" type="button" data-wishlist><img src="assets/product-detail/heart.svg" alt="">Add Wishlist</button>

        <div class="pdp__buttons">
          <button class="pdp-btn pdp-btn--outline" type="button" data-add-to-cart>Add to Cart</button>
          <button class="pdp-btn pdp-btn--solid" type="button" data-add-to-cart data-buy-now>Buy Now</button>
        </div>

        <ul class="pdp__perks">
          <li><span class="pdp__icon"><img src="assets/product-detail/truck.svg" alt=""></span>Free Shipping on Orders above Rs 1,999</li>
          <li><span class="pdp__icon"><img src="assets/product-detail/box.svg" alt=""></span>Shipped within 48 business hours</li>
          <li><span class="pdp__icon"><img src="assets/product-detail/delivery.svg" alt=""></span><span>Delivery within 7 business days after dispatch. View <a href="#">Shipping Policy</a></span></li>
        </ul>

        <h2 class="pdp__offers-title">Available Offers</h2>
        <button class="pdp__offer" type="button" aria-label="Copy offer code WELCOME10" data-copy-code="WELCOME10">
          <img src="assets/product-detail/offer.png" alt="">
          <span class="pdp__offer-note" role="status" data-copy-status></span>
        </button>

        <div class="pdp-accordion">
          <div class="pdp-accordion__item">
            <details>
              <summary>Product Details<img src="assets/product-detail/plus.svg" alt=""></summary>
              <div class="pdp-accordion__body">
                <p data-product-detail="product">Organza saree in cream with teal blue and olive golden wavy stripes, finished with a beaded scalloped border. Comes with an unstitched blouse piece.</p>
              </div>
            </details>
            <img class="pdp-accordion__rule" src="assets/product-detail/accordion-rule.svg" alt="">
          </div>
          <div class="pdp-accordion__item">
            <details>
              <summary>Design Details<img src="assets/product-detail/plus.svg" alt=""></summary>
              <div class="pdp-accordion__body">
                <p data-product-detail="design">Printed wavy stripe pattern across the body and pallu, with a hand-beaded scalloped edge.</p>
              </div>
            </details>
            <img class="pdp-accordion__rule" src="assets/product-detail/accordion-rule.svg" alt="">
          </div>
          <div class="pdp-accordion__item">
            <details>
              <summary>Material &amp; Care<img src="assets/product-detail/plus.svg" alt=""></summary>
              <div class="pdp-accordion__body">
                <p data-product-detail="care">Fabric: Organza. Dry clean only. Store folded in a muslin cloth, away from direct sunlight.</p>
              </div>
            </details>
            <img class="pdp-accordion__rule" src="assets/product-detail/accordion-rule.svg" alt="">
          </div>
        </div>

        <div class="pdp__share">
          <span class="pdp__share-label">Share :</span>
          <a href="#" aria-label="Share on Facebook"><img src="assets/product-detail/share-facebook.svg" alt=""></a>
          <a href="#" aria-label="Share on Twitter"><img src="assets/product-detail/share-twitter.svg" alt=""></a>
          <a href="#" aria-label="Share on LinkedIn"><img src="assets/product-detail/share-linkedin.svg" alt=""></a>
          <a href="#" aria-label="Share on Instagram"><img src="assets/product-detail/share-instagram.svg" alt=""></a>
          <a href="#" aria-label="Share on Pinterest"><img src="assets/product-detail/share-pinterest.svg" alt=""></a>
          <a href="#" aria-label="Share on YouTube"><img src="assets/product-detail/share-youtube.svg" alt=""></a>
        </div>
      </div>
    </section>

    <!-- ============ You May Also Like (Figma 273:2116 / 273:2117) ============ -->
    <section class="pdp-related" aria-labelledby="related-title">
      <h2 class="pdp-heading" id="related-title">You May Also Like</h2>
      <!-- Slider: arrows step one card at a time; the track also scrolls by swipe / trackpad (js/product.js). -->
      <div class="slider slider--related" data-slider>
        <button class="carousel-nav slider__nav slider__nav--prev" type="button" aria-label="Previous products" aria-controls="related-track" data-slider-prev><img src="assets/carousel/prev.svg" alt=""></button>
        <button class="carousel-nav slider__nav slider__nav--next" type="button" aria-label="Next products" aria-controls="related-track" data-slider-next><img src="assets/carousel/next.svg" alt=""></button>
        <div class="product-grid slider__track" id="related-track" data-slider-track>
        <article class="product" data-category="saree" data-color="mustard magenta" data-pattern="zari-brocade" data-fabric="semi-silk" data-blouse="yes" data-occasion="festive">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/ss-1.png" alt="Mustard yellow semi silk saree with silver zari pallu" style="--x:0.875px;--y:0.167px;--w:443.962px;--h:594.839px">
            <img class="product__photo product__photo--hover" src="assets/products/ss-1-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product.html?p=ss-1">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product.html?p=ss-1">Semi Silk Saree Mustard Yellow with Silver Zari Geometric Brocade Pallu and Magenta Border</a></h3>
          <p class="product__price">₹ 4,595.00</p>
        </article>
        <article class="product" data-category="saree" data-color="purple" data-pattern="zari-brocade stripes" data-fabric="semi-silk" data-blouse="yes" data-occasion="festive wedding">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/ss-2.png" alt="Deep purple semi silk saree with rose copper zari pallu" style="--x:-8px;--y:-13px;--w:457.104px;--h:612.448px">
            <img class="product__photo product__photo--hover" src="assets/products/ss-2-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product.html?p=ss-2">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product.html?p=ss-2">Semi Silk Saree Deep Purple with Rose Copper Zari Brocade Striped Pallu and Paisley Border</a></h3>
          <p class="product__price">₹ 4,595.00</p>
        </article>
        <article class="product" data-category="saree" data-color="mehandi-green" data-pattern="zari-brocade" data-fabric="semi-silk" data-blouse="yes" data-occasion="festive">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/na-3a.png" alt="" style="--x:-2px;--y:-12px;--w:454px;--h:599px">
            <img class="product__photo" src="assets/products/ss-3.png" alt="Olive green semi silk saree with golden zari pallu" style="--x:-6px;--y:-16.89px;--w:450.717px;--h:603.89px">
            <img class="product__photo product__photo--hover" src="assets/products/ss-3-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product.html?p=ss-3">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product.html?p=ss-3">Semi Silk Saree Olive Green with Golden Zari Geometric Weave Pallu and Purple Tassels</a></h3>
          <p class="product__price">₹ 3,760.00</p>
        </article>
        <article class="product" data-category="saree" data-color="purple magenta" data-pattern="zari-butta" data-fabric="semi-silk" data-blouse="yes" data-occasion="festive wedding">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/ss-4.png" alt="Deep purple semi silk saree with magenta pallu" style="--x:-10px;--y:-15px;--w:451px;--h:601.921px">
            <img class="product__photo product__photo--hover" src="assets/products/ss-4-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product.html?p=ss-4">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product.html?p=ss-4">Semi Silk Deep Purple Zari Floral Jaal Magenta Pallu Diamond Booti saree</a></h3>
          <p class="product__price">₹ 4,595.00</p>
        </article>
        <article class="product" data-category="saree" data-color="teal" data-pattern="plain-body" data-fabric="chiffon" data-blouse="yes" data-occasion="festive party" data-new>
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/na-1.png" alt="Chiffon peacock green saree" style="--x:1px;--y:0px;--w:440px;--h:587px">
            <img class="product__photo product__photo--hover" src="assets/products/na-1-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product.html?p=na-1">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product.html?p=na-1">Chiffon Peacock Green Saree with Crystal Embellished Teardrop Lace Border and Plain Body</a></h3>
          <p class="product__price">₹ 3,580.00</p>
        </article>
        <article class="product" data-category="saree" data-color="peacock-blue black" data-pattern="printed floral-print" data-fabric="organza" data-blouse="yes" data-occasion="festive party" data-new>
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/na-2.png" alt="Organza peacock blue saree" style="--x:-8px;--y:-13px;--w:458px;--h:614px">
            <img class="product__photo product__photo--hover" src="assets/products/na-2-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product.html?p=na-2">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product.html?p=na-2">Organza Peacock Blue Black Lily Floral Butta Printed Saree with Beaded Zigzag Border</a></h3>
          <p class="product__price">₹ 3,550.00</p>
        </article>
        <article class="product" data-category="saree" data-color="pink multi" data-pattern="embroidery" data-fabric="organza" data-blouse="yes" data-occasion="wedding party" data-new>
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/na-4.png" alt="Organza pink floral embroidered saree" style="--x:-10px;--y:-15px;--w:457px;--h:613px">
            <img class="product__photo product__photo--hover" src="assets/products/na-4-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product.html?p=na-4">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product.html?p=na-4">Organza Pink Multicolor Floral Embroidered Scalloped Border Saree with Sequin Work</a></h3>
          <p class="product__price">₹ 13,900.00</p>
        </article>
        <article class="product" data-category="ready-to-wear" data-color="violet" data-pattern="embroidery" data-fabric="georgette" data-blouse="yes" data-occasion="party">
          <div class="product__media">
            <img class="product__base" src="assets/products/card-base.png" alt="">
            <img class="product__photo" src="assets/products/rtw-3.png" alt="Violet georgette ready to wear saree" style="--x:-6px;--y:-23px;--w:454px;--h:679px">
            <img class="product__photo product__photo--hover" src="assets/products/rtw-3-hover.png" alt="" loading="lazy">
            <div class="product__actions">
              <div class="product__cta">
                <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
              </div>
              <div class="product__quick">
                <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product.html?p=rtw-3">Quick View</a>
              </div>
            </div>
          </div>
          <h3 class="product__title"><a href="product.html?p=rtw-3">Violet Georgette Ready to Wear Saree with Designer...</a></h3>
          <p class="product__price">₹ 4,595.00</p>
        </article>
        </div>
      </div>
    </section>

    <!-- ============ Testimonials (Figma 273:2164 – 273:2215) ============ -->
    <section class="pdp-testimonials" aria-labelledby="testimonials-title">
      <h2 class="pdp-heading" id="testimonials-title">Trusted for Every Special Occasion</h2>
      <!-- Slider (as You May Also Like): arrows step one review at a time and it auto-slides. -->
      <div class="slider slider--testimonials" data-slider>
        <button class="carousel-nav slider__nav slider__nav--dark slider__nav--prev" type="button" aria-label="Previous reviews" aria-controls="testimonial-track" data-slider-prev><img src="assets/carousel/arrow.svg" alt=""></button>
        <button class="carousel-nav slider__nav slider__nav--dark slider__nav--next" type="button" aria-label="Next reviews" aria-controls="testimonial-track" data-slider-next><img src="assets/carousel/arrow.svg" alt=""></button>
        <div class="slider__track" id="testimonial-track" data-slider-track>
        <figure class="testimonial">
          <span class="stars" role="img" aria-label="5 stars"><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""></span>
          <blockquote>
            <p class="testimonial__headline">Quality, Fit, and Care</p>
            <p class="testimonial__text">I really appreciate the quality and variety, along with the overall experience. The customer care team was professional and quick to assist. When I couldn't find a suitable fit, they arranged same-day custom stitching, Which was impressive. The fit <br>and quality were exactly what I wanted. I also sent a dress to a friend in Oman through their online service, and everything was handled</p>
          </blockquote>
          <figcaption><span class="testimonial__name">Stephen James</span><span class="testimonial__place">Dubai, UAE</span></figcaption>
        </figure>
        <figure class="testimonial">
          <span class="stars" role="img" aria-label="5 stars"><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""></span>
          <blockquote>
            <p class="testimonial__headline">Quality, Fit, and Care</p>
            <p class="testimonial__text">I really appreciate the quality and variety, along with the overall experience. The customer care team was professional and quick to assist. When I couldn't find a suitable fit, they arranged same-day custom stitching, Which was impressive. The fit <br>and quality were exactly what I wanted. I also sent a dress to a friend in Oman through their online service, and everything was handled</p>
          </blockquote>
          <figcaption><span class="testimonial__name">Stephen James</span><span class="testimonial__place">Dubai, UAE</span></figcaption>
        </figure>
        <figure class="testimonial">
          <span class="stars" role="img" aria-label="5 stars"><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""></span>
          <blockquote>
            <p class="testimonial__headline">Quality, Fit, and Care</p>
            <p class="testimonial__text">I really appreciate the quality and variety, along with the overall experience. The customer care team was professional and quick to assist. When I couldn't find a suitable fit, they arranged same-day custom stitching, Which was impressive. The fit <br>and quality were exactly what I wanted. I also sent a dress to a friend in Oman through their online service, and everything was handled</p>
          </blockquote>
          <figcaption><span class="testimonial__name">Stephen James</span><span class="testimonial__place">Dubai, UAE</span></figcaption>
        </figure>
        <figure class="testimonial">
          <span class="stars" role="img" aria-label="5 stars"><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""></span>
          <blockquote>
            <p class="testimonial__headline">Beautiful Drape and Finish</p>
            <p class="testimonial__text">The organza saree looked even better in person. The colours were exactly as shown, the beadwork on the border was neat, and it arrived well packed two days before my event. I received so many compliments.</p>
          </blockquote>
          <figcaption><span class="testimonial__name">Priya Nair</span><span class="testimonial__place">Abu Dhabi, UAE</span></figcaption>
        </figure>
        <figure class="testimonial">
          <span class="stars" role="img" aria-label="5 stars"><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""></span>
          <blockquote>
            <p class="testimonial__headline">Helpful and Quick Service</p>
            <p class="testimonial__text">I needed a blouse altered at short notice and the team handled it the same day. They kept me updated on WhatsApp and the fit was perfect. Easily the smoothest shopping experience I have had for ethnic wear.</p>
          </blockquote>
          <figcaption><span class="testimonial__name">Fathima Rahman</span><span class="testimonial__place">Sharjah, UAE</span></figcaption>
        </figure>
        <figure class="testimonial">
          <span class="stars" role="img" aria-label="5 stars"><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""></span>
          <blockquote>
            <p class="testimonial__headline">Worth Every Dirham</p>
            <p class="testimonial__text">Lovely fabric quality and the zari work is rich without feeling heavy. I ordered two sarees for a wedding and both were true to the photos. Will definitely shop again for the festive season.</p>
          </blockquote>
          <figcaption><span class="testimonial__name">Anjali Menon</span><span class="testimonial__place">Dubai, UAE</span></figcaption>
        </figure>
        </div>
      </div>
    </section>

    <!-- ============ Customer Reviews (Figma 273:2227 / 273:2246) ============ -->
    <section class="pdp-reviews" aria-labelledby="reviews-title">
      <h2 class="pdp-reviews__title" id="reviews-title">Customer Reviews</h2>
      <div class="pdp-reviews__row">
        <div class="pdp-reviews__empty">
          <span class="stars" role="img" aria-label="5 stars"><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""><img src="assets/product-detail/star.svg" alt=""></span>
          <p>Be the first to write a review</p>
        </div>
        <span class="pdp-reviews__divider"><img src="assets/product-detail/review-divider.svg" alt=""></span>
        <button class="pdp-btn pdp-btn--solid" type="button" data-write-review>Write a Review</button>
      </div>
    </section>

  </main>
@endsection

@section('after')
<!-- Review pop-up: opened by Write a Review (js/product.js). Choosing a star rating shows the
     comment fields; sending shows a thank-you note. -->
<dialog class="review-dialog" id="review-dialog" aria-labelledby="review-title">
  <button class="review-dialog__close" type="button" aria-label="Close" data-review-close>
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
  </button>
  <form class="review-form" data-review-form novalidate>
    <h2 class="review-dialog__title" id="review-title">How would you rate this product?</h2>
    <p class="review-dialog__lead">We would love it if you would share a bit about your experience.</p>
    <img class="review-dialog__photo" src="assets/products/na-3a.png" alt="" data-review-photo>
    <p class="review-dialog__product" data-review-product>Organza Cream Teal Blue and Olive Golden Wavy Stripe Printed Saree with Beaded Scalloped Border</p>

    <fieldset class="review-rating" data-review-rating>
      <legend class="visually-hidden">Your rating</legend>
      <div class="review-rating__stars">
        <label class="review-star"><input class="visually-hidden" type="radio" name="rating" value="1" required><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.6l2.9 6 6.6.9-4.8 4.6 1.2 6.5L12 17.5l-5.9 3.1 1.2-6.5-4.8-4.6 6.6-.9z"/></svg><span class="visually-hidden">1 star, Poor</span></label>
        <label class="review-star"><input class="visually-hidden" type="radio" name="rating" value="2"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.6l2.9 6 6.6.9-4.8 4.6 1.2 6.5L12 17.5l-5.9 3.1 1.2-6.5-4.8-4.6 6.6-.9z"/></svg><span class="visually-hidden">2 stars</span></label>
        <label class="review-star"><input class="visually-hidden" type="radio" name="rating" value="3"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.6l2.9 6 6.6.9-4.8 4.6 1.2 6.5L12 17.5l-5.9 3.1 1.2-6.5-4.8-4.6 6.6-.9z"/></svg><span class="visually-hidden">3 stars</span></label>
        <label class="review-star"><input class="visually-hidden" type="radio" name="rating" value="4"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.6l2.9 6 6.6.9-4.8 4.6 1.2 6.5L12 17.5l-5.9 3.1 1.2-6.5-4.8-4.6 6.6-.9z"/></svg><span class="visually-hidden">4 stars</span></label>
        <label class="review-star"><input class="visually-hidden" type="radio" name="rating" value="5"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.6l2.9 6 6.6.9-4.8 4.6 1.2 6.5L12 17.5l-5.9 3.1 1.2-6.5-4.8-4.6 6.6-.9z"/></svg><span class="visually-hidden">5 stars, Great</span></label>
      </div>
      <div class="review-rating__labels" aria-hidden="true"><span>Poor</span><span>Great</span></div>
    </fieldset>

    <div class="review-form__fields" data-review-fields hidden>
      <label class="review-field"><span>Review title</span><input type="text" name="title" maxlength="80" placeholder="Sum it up in a few words"></label>
      <label class="review-field"><span>Your review</span><textarea name="review" rows="4" required placeholder="What did you like or dislike?"></textarea></label>
      <label class="review-field"><span>Your name</span><input type="text" name="name" required autocomplete="name"></label>
      <p class="review-form__error" role="alert" data-review-error></p>
      <button class="pdp-btn pdp-btn--solid review-form__submit" type="submit">Submit Review</button>
    </div>
  </form>
  <div class="review-dialog__thanks" data-review-thanks hidden>
    <h2 class="review-dialog__title">Thank you for your review!</h2>
    <p class="review-dialog__lead">Your feedback helps other shoppers choose with confidence.</p>
    <button class="pdp-btn pdp-btn--solid" type="button" data-review-close>Close</button>
  </div>
</dialog>
@endsection
