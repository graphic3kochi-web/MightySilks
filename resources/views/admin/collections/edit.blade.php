@extends('layouts.admin')

@section('title', $collection->name)
@section('crumb', $collection->name)

@section('content')
<div class="adm-head">
  <div>
    <h1>{{ $collection->name }}</h1>
    <p><a href="{{ url($collection->slug.'.html') }}" target="_blank" rel="noopener">/{{ $collection->slug }}.html</a> · {{ $products->count() }} products</p>
  </div>
</div>

<form class="adm-form" method="post" action="{{ route('admin.collections.update', $collection) }}">
  @csrf @method('put')
  <section class="adm-card">
    <div class="adm-card__head"><span class="adm-card__icon"><i class="fa-solid fa-table-cells"></i></span><div><h2 class="adm-card__title">Products on this page</h2><p class="adm-card__sub">As the grid shows them, left to right, top to bottom.</p></div></div>
    <div class="adm-table-wrap">
      <table class="adm-table">
        <thead><tr><th>#</th><th>Product</th><th>Code</th><th class="num">Price</th><th>Status</th></tr></thead>
        <tbody>
          @forelse ($products as $i => $product)
            <tr>
              <td class="muted">{{ $i + 1 }}</td>
              <td><div class="adm-cell"><img class="adm-thumb" src="{{ asset($product->image()) }}" alt="" loading="lazy"><a href="{{ route('admin.products.edit', $product) }}">{{ $product->title }}</a></div></td>
              <td class="muted">{{ $product->code }}</td>
              <td class="num">{{ inr($product->price) }}</td>
              <td><span class="adm-badge adm-badge--{{ $product->is_active ? 'active' : 'closed' }}">{{ $product->is_active ? 'Visible' : 'Hidden' }}</span></td>
            </tr>
          @empty
            <tr><td colspan="5" class="adm-empty">No products on this page yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>

  <div>
    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon adm-card__icon--gold"><i class="fa-solid fa-arrow-down-1-9"></i></span><h2 class="adm-card__title">Arrange</h2></div>
      <div class="adm-grid" style="grid-template-columns:1fr">
        <x-admin.field name="name" label="Name" :value="$collection->name" required />
        <x-admin.field name="codes" label="Product codes, in order" type="textarea" rows="16" :value="$products->pluck('code')->implode(PHP_EOL)" help="One code per line. Move lines to reorder, delete a line to take a product off this page, add a code to put one on." style="font-family:ui-monospace,monospace; font-size:13px" />
      </div>
    </section>
    <div class="adm-form__bar">
      <a class="adm-btn adm-btn--ghost" href="{{ route('admin.collections.index') }}">Back</a>
      <button class="adm-btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save</button>
    </div>
  </div>
</form>
@endsection
