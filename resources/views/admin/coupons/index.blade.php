@extends('layouts.admin')

@section('title', 'Coupons')
@section('crumb', 'Coupons')

@section('content')
<div class="adm-head">
  <div>
    <h1>Coupons</h1>
    <p>The featured coupon is offered in the cart drawer and accepted at checkout</p>
  </div>
  <div class="adm-head__actions"><a class="adm-btn" href="{{ route('admin.coupons.create') }}"><i class="fa-solid fa-plus"></i> Add Coupon</a></div>
</div>

<section class="adm-card">
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Code</th><th>Discount</th><th>Minimum order</th><th class="num">Used</th><th>Expires</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($coupons as $coupon)
          <tr>
            <td><a href="{{ route('admin.coupons.edit', $coupon) }}">{{ $coupon->code }}</a><br><span class="muted">{{ $coupon->description }}</span></td>
            <td>{{ $coupon->percent }}% off</td>
            <td>{{ (float) $coupon->min_subtotal ? inr($coupon->min_subtotal) : '—' }}</td>
            <td class="num">{{ $coupon->used_count }}{{ $coupon->max_uses ? ' / '.$coupon->max_uses : '' }}</td>
            <td>{{ $coupon->expires_at?->format('d M Y') ?? 'Never' }}</td>
            <td>
              <span class="adm-badge adm-badge--{{ $coupon->is_active ? 'active' : 'closed' }}">{{ $coupon->is_active ? 'Active' : 'Off' }}</span>
              @if ($coupon->is_featured)<span class="adm-badge adm-badge--packed">Featured</span>@endif
            </td>
            <td>
              <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost adm-btn--sm" href="{{ route('admin.coupons.edit', $coupon) }}">Edit</a>
                <form method="post" action="{{ route('admin.coupons.destroy', $coupon) }}" data-confirm="Delete {{ $coupon->code }}?">@csrf @method('delete')<button class="adm-btn adm-btn--danger adm-btn--sm" type="submit" aria-label="Delete"><i class="fa-solid fa-trash"></i></button></form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="adm-empty">No coupons yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>
@endsection
