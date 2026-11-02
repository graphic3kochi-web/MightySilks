          <article class="product" data-category="{{ $product->category }}" data-color="{{ $product->color }}" data-pattern="{{ $product->pattern }}" data-fabric="{{ $product->fabric }}" data-blouse="{{ $product->blouse }}" data-occasion="{{ $product->occasion }}"@if ($product->is_new) data-new @endif>
            <div class="product__media">
              <img class="product__base" src="assets/products/card-base.png" alt="">
              @foreach ($product->card_layers as $layer)
              <img class="product__photo{{ ! empty($layer['fill']) ? ' product__photo--fill' : '' }}" src="{{ $layer['src'] }}" alt="{{ $layer['alt'] ?? '' }}"@isset($layer['style']) style="{{ $layer['style'] }}"@endisset>
              @endforeach
              @if ($product->hover_image)
              <img class="product__photo product__photo--hover" src="{{ $product->hover_image }}" alt="" loading="lazy">
              @endif
              <div class="product__actions">
                <div class="product__cta">
                  <button class="btn-cart" type="button">Add to Cart <img src="assets/icons/bag.svg" alt=""></button>
                  <button class="btn-wish" type="button" aria-label="Add to wishlist"><img src="assets/icons/heart.svg" alt=""></button>
                </div>
                <div class="product__quick">
                  <button type="button">Buy Now</button><span class="product__quick-divider"><img src="assets/icons/divider.svg" alt=""></span><a href="product?p={{ $product->code }}">Quick View</a>
                </div>
              </div>
            </div>
            <h3 class="product__title"><a href="product?p={{ $product->code }}">{{ $product->title }}</a></h3>
            <p class="product__price">{{ inr($product->price) }}</p>
          </article>
