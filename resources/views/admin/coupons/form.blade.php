@extends('layouts.admin')

@section('title', $coupon->exists ? $coupon->code : 'Add Coupon')
@section('crumb', $coupon->exists ? 'Edit Coupon' : 'Add Coupon')

@section('content')
<div class="adm-head"><h1>{{ $coupon->exists ? 'Edit '.$coupon->code : 'Add Coupon' }}</h1></div>

<form class="adm-form" method="post" action="{{ $coupon->exists ? route('admin.coupons.update', $coupon) : route('admin.coupons.store') }}">
  @csrf
  @if ($coupon->exists) @method('put') @endif
  <section class="adm-card">
    <div class="adm-grid">
      <x-admin.field name="code" label="Code" :value="$coupon->code" required help="Letters and numbers, e.g. DIWALI15." style="text-transform:uppercase" />
      <x-admin.field name="percent" label="Discount (%)" type="number" min="1" max="90" :value="$coupon->percent" required />
      <x-admin.field name="description" label="Internal note" :value="$coupon->description" wide />
      <x-admin.field name="min_subtotal" label="Minimum order (₹)" type="number" min="0" step="1" :value="(float) $coupon->min_subtotal ?: null" />
      <x-admin.field name="max_uses" label="Maximum uses" type="number" min="1" :value="$coupon->max_uses" help="Empty: unlimited." />
      <x-admin.field name="expires_at" label="Expires on" type="date" :value="$coupon->expires_at?->toDateString()" />
    </div>
  </section>
  <div>
    <section class="adm-card" style="display:grid; gap:10px">
      <x-admin.check name="is_active" label="Active" :checked="$coupon->is_active" />
      <x-admin.check name="is_featured" label="Feature in the cart drawer" :checked="$coupon->is_featured" />
      <p class="muted">Featuring this coupon replaces the one featured now.</p>
    </section>
    <div class="adm-form__bar">
      <a class="adm-btn adm-btn--ghost" href="{{ route('admin.coupons.index') }}">Cancel</a>
      <button class="adm-btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save</button>
    </div>
  </div>
</form>
@endsection
