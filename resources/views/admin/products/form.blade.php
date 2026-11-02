@extends('layouts.admin')

@section('title', $product->exists ? $product->title : 'Add Product')
@section('crumb', $product->exists ? 'Edit Product' : 'Add Product')

@section('content')
@php $words = fn ($slugs) => str_replace('-', ' ', (string) $slugs); @endphp
<div class="adm-head">
  <div>
    <h1>{{ $product->exists ? 'Edit Product' : 'Add Product' }}</h1>
    @if ($product->exists)<p>{{ $product->code }} · <a href="{{ url('product?p='.$product->code) }}" target="_blank" rel="noopener">View on site</a></p>@endif
  </div>
  @if ($product->exists)
    <div class="adm-head__actions">
      <form method="post" action="{{ route('admin.products.destroy', $product) }}" data-confirm="Delete this product? Past orders keep their copy of it.">
        @csrf @method('delete')
        <button class="adm-btn adm-btn--danger" type="submit"><i class="fa-solid fa-trash"></i> Delete</button>
      </form>
    </div>
  @endif
</div>

<form class="adm-form" method="post" enctype="multipart/form-data" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}">
  @csrf
  @if ($product->exists) @method('put') @endif

  <div>
    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon"><i class="fa-solid fa-shirt"></i></span><h2 class="adm-card__title">Details</h2></div>
      <div class="adm-grid">
        <x-admin.field name="title" label="Title (shop card)" :value="$product->title" required wide />
        <x-admin.field name="page_title" label="Product page heading" :value="$product->page_title" help="Leave empty to use the title." wide />
        <x-admin.field name="price" label="Price (₹)" type="number" step="0.01" min="0" :value="$product->price" required />
        <x-admin.field name="stock" label="Stock" type="number" min="0" :value="$product->stock" required />
        <x-admin.field name="sku" label="SKU" :value="$product->sku" />
        <x-admin.field name="code" label="Product code" :value="$product->code" help="The link: /product?p=code. Leave empty to generate one." />
        <x-admin.field name="alt" label="Photo description (alt text)" :value="$product->alt" wide />
      </div>
    </section>

    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon adm-card__icon--teal"><i class="fa-solid fa-filter"></i></span><div><h2 class="adm-card__title">Shop filters</h2><p class="adm-card__sub">Words separated by commas or spaces, e.g. “peacock blue, gold”. They feed the shop page filters and product details.</p></div></div>
      <div class="adm-grid">
        <x-admin.field name="category" label="Category" :options="\App\Models\Product::CATEGORIES" :value="$product->category" />
        <x-admin.field name="blouse" label="Blouse piece" :options="['yes' => 'Included', 'no' => 'Not included']" :value="$product->blouse" />
        <x-admin.field name="color" label="Colours" :value="$words($product->color)" />
        <x-admin.field name="fabric" label="Fabric" :value="$words($product->fabric)" />
        <x-admin.field name="pattern" label="Pattern" :value="$words($product->pattern)" />
        <x-admin.field name="occasion" label="Occasion" :value="$words($product->occasion)" />
      </div>
    </section>

    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon adm-card__icon--gold"><i class="fa-solid fa-align-left"></i></span><div><h2 class="adm-card__title">Product page details</h2><p class="adm-card__sub">The expandable sections under the offers. Leave one empty to write it from the shop filters.</p></div></div>
      <div class="adm-grid">
        <x-admin.field name="product_details" label="Product Details" type="textarea" rows="3" :value="$product->product_details" wide />
        <x-admin.field name="design_details" label="Design Details" type="textarea" rows="3" :value="$product->design_details" wide />
        <x-admin.field name="material_care" label="Material & Care" type="textarea" rows="3" :value="$product->material_care" wide />
      </div>
    </section>

    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon adm-card__icon--blue"><i class="fa-solid fa-images"></i></span><div><h2 class="adm-card__title">Product page photos</h2><p class="adm-card__sub">The first photo is the main one. Tick a photo to remove it.</p></div></div>
      @if ($product->gallery)
        <div class="adm-gallery">
          @foreach ($product->gallery as $i => $src)
            <label>
              <img src="{{ asset($src) }}" alt="Photo {{ $i + 1 }}">
              <span><input type="checkbox" name="remove_images[]" value="{{ $src }}"> Remove</span>
            </label>
          @endforeach
        </div>
      @endif
      <div class="adm-grid" style="margin-top:14px">
        <x-admin.field name="images[]" label="Add photos" type="file" accept="image/*" multiple help="JPG, PNG or WebP, up to 4 MB each." wide />
      </div>
      @error('images')<p class="adm-error" style="color:var(--red)">{{ $message }}</p>@enderror
    </section>
  </div>

  <div>
    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon adm-card__icon--green"><i class="fa-solid fa-eye"></i></span><h2 class="adm-card__title">Visibility</h2></div>
      <div style="display:grid; gap:10px">
        <x-admin.check name="is_active" label="Visible on the site" :checked="$product->is_active" />
        <x-admin.check name="is_new" label="Mark as New Arrival" :checked="$product->is_new" />
      </div>
    </section>

    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon adm-card__icon--gold"><i class="fa-solid fa-id-card"></i></span><div><h2 class="adm-card__title">Shop card</h2><p class="adm-card__sub">How the product shows in shop grids.</p></div></div>
      <div class="adm-gallery">
        @if ($product->card_layers)
          <label><img src="{{ asset(last($product->card_layers)['src']) }}" alt="Card photo"><span>Card</span></label>
        @endif
        @if ($product->hover_image)
          <label><img src="{{ asset($product->hover_image) }}" alt="Hover photo"><span><input type="checkbox" name="remove_hover" value="1"> Remove hover</span></label>
        @endif
      </div>
      <div class="adm-grid" style="grid-template-columns:1fr; margin-top:12px">
        <x-admin.field name="card_image" label="Replace card photo" type="file" accept="image/*" help="Empty: the first product photo is used for new products." />
        <x-admin.field name="hover_image" label="{{ $product->hover_image ? 'Replace' : 'Add' }} hover photo" type="file" accept="image/*" help="Shown when a shopper hovers the card." />
      </div>
    </section>

    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon"><i class="fa-solid fa-layer-group"></i></span><div><h2 class="adm-card__title">Shown on pages</h2><p class="adm-card__sub">The shop pages whose grid lists this product.</p></div></div>
      <div class="adm-checks" style="grid-template-columns:1fr">
        @foreach ($collections as $collection)
          <label class="adm-check"><input type="checkbox" name="collections[]" value="{{ $collection->id }}" @checked(in_array($collection->id, old('collections', $selected)))> {{ $collection->name }}</label>
        @endforeach
      </div>
    </section>

    <div class="adm-form__bar">
      <a class="adm-btn adm-btn--ghost" href="{{ route('admin.products.index') }}">Cancel</a>
      <button class="adm-btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save Product</button>
    </div>
  </div>
</form>
@endsection
