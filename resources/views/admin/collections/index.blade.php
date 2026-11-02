@extends('layouts.admin')

@section('title', 'Collections')
@section('crumb', 'Collections')

@section('content')
<div class="adm-head">
  <div>
    <h1>Collections</h1>
    <p>Each shop page lists the products of its collection, in the order set here</p>
  </div>
</div>

<section class="adm-card">
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Page</th><th>Address</th><th class="num">Products</th><th></th></tr></thead>
      <tbody>
        @foreach ($collections as $collection)
          <tr>
            <td><a href="{{ route('admin.collections.edit', $collection) }}">{{ $collection->name }}</a></td>
            <td class="muted">/{{ $collection->slug }}.html</td>
            <td class="num">{{ $collection->products_count }}</td>
            <td>
              <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost adm-btn--sm" href="{{ url($collection->slug.'.html') }}" target="_blank" rel="noopener" aria-label="View page"><i class="fa-solid fa-eye"></i></a>
                <a class="adm-btn adm-btn--ghost adm-btn--sm" href="{{ route('admin.collections.edit', $collection) }}">Edit</a>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>
@endsection
