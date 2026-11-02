@extends('layouts.admin')

@section('title', 'Products')
@section('crumb', 'Products')

@section('content')
<div class="adm-head">
  <div>
    <h1>Products</h1>
    <p>{{ $total }} products in the catalogue</p>
  </div>
  <div class="adm-head__actions">
    <a class="adm-btn" href="{{ route('admin.products.create') }}"><i class="fa-solid fa-plus"></i> Add Product</a>
  </div>
</div>

<section class="adm-card">
  <form class="adm-filters" method="get">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Title, code or SKU" aria-label="Search products">
    <select name="category" aria-label="Category" onchange="this.form.submit()">
      <option value="">All categories</option>
      @foreach (\App\Models\Product::CATEGORIES as $key => $label)
        <option value="{{ $key }}" @selected(request('category') === $key)>{{ $label }}</option>
      @endforeach
    </select>
    <select name="status" aria-label="Visibility" onchange="this.form.submit()">
      <option value="">Visible &amp; hidden</option>
      <option value="active" @selected(request('status') === 'active')>Visible</option>
      <option value="hidden" @selected(request('status') === 'hidden')>Hidden</option>
    </select>
    <select name="stock" aria-label="Stock" onchange="this.form.submit()">
      <option value="">Any stock</option>
      <option value="low" @selected(request('stock') === 'low')>Low stock (≤ 3)</option>
    </select>
    <button class="adm-btn adm-btn--ghost" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
    @if (request()->hasAny(['q', 'category', 'status', 'stock']))<a class="adm-btn adm-btn--ghost" href="{{ route('admin.products.index') }}">Clear</a>@endif
  </form>

  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Product</th><th>Category</th><th class="num">Price</th><th class="num">Stock</th><th>Pages</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($products as $product)
          <tr>
            <td>
              <div class="adm-cell">
                <img class="adm-thumb" src="{{ asset($product->image()) }}" alt="" loading="lazy">
                <span><a href="{{ route('admin.products.edit', $product) }}">{{ $product->title }}</a><br><span class="muted">{{ $product->code }}@if ($product->sku) · SKU {{ $product->sku }}@endif</span></span>
              </div>
            </td>
            <td>{{ $product->categoryLabel() }}</td>
            <td class="num">{{ inr($product->price) }}</td>
            <td class="num">@if ($product->stock <= 3)<span class="adm-badge adm-badge--pending">{{ $product->stock }}</span>@else{{ $product->stock }}@endif</td>
            <td>{{ $product->collections_count }}</td>
            <td>
              <span class="adm-badge adm-badge--{{ $product->is_active ? 'active' : 'closed' }}">{{ $product->is_active ? 'Visible' : 'Hidden' }}</span>
              @if ($product->is_new)<span class="adm-badge adm-badge--packed">New</span>@endif
            </td>
            <td>
              <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost adm-btn--sm" href="{{ url('product.html?p='.$product->code) }}" target="_blank" rel="noopener" aria-label="View on site"><i class="fa-solid fa-eye"></i></a>
                <a class="adm-btn adm-btn--ghost adm-btn--sm" href="{{ route('admin.products.edit', $product) }}">Edit</a>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="adm-empty">No products match.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $products->links() }}
</section>
@endsection
