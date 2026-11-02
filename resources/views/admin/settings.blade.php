@extends('layouts.admin')

@section('title', 'Settings')
@section('crumb', 'Settings')

@section('content')
<div class="adm-head"><div><h1>Settings</h1><p>Store details, shipping rates and your admin account</p></div></div>

<form class="adm-form" method="post" action="{{ route('admin.settings.update') }}">
  @csrf @method('put')
  <div>
    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon"><i class="fa-solid fa-store"></i></span><h2 class="adm-card__title">Store</h2></div>
      <div class="adm-grid">
        <x-admin.field name="store_name" label="Store name" :value="$settings['store_name']" required wide />
        <x-admin.field name="contact_email" label="Contact email" type="email" :value="$settings['contact_email']" required />
        <x-admin.field name="contact_phone" label="Contact phone" :value="$settings['contact_phone']" required />
      </div>
    </section>
    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon adm-card__icon--teal"><i class="fa-solid fa-truck"></i></span><div><h2 class="adm-card__title">Shipping</h2><p class="adm-card__sub">Used by checkout and when orders are priced.</p></div></div>
      <div class="adm-grid adm-grid--3">
        <x-admin.field name="free_shipping_from" label="Free standard shipping from (₹)" type="number" min="0" :value="$settings['free_shipping_from']" required />
        <x-admin.field name="standard_shipping" label="Standard shipping (₹)" type="number" min="0" :value="$settings['standard_shipping']" required />
        <x-admin.field name="express_shipping" label="Express shipping (₹)" type="number" min="0" :value="$settings['express_shipping']" required />
      </div>
    </section>
    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon adm-card__icon--gold"><i class="fa-solid fa-briefcase"></i></span><h2 class="adm-card__title">Careers</h2></div>
      <x-admin.field name="job_offer" label="What every role offers" type="textarea" rows="5" :value="$settings['job_offer']" help="One benefit per line." />
    </section>
  </div>
  <div>
    <section class="adm-card">
      <div class="adm-card__head"><span class="adm-card__icon adm-card__icon--blue"><i class="fa-solid fa-user-shield"></i></span><h2 class="adm-card__title">Your account</h2></div>
      <div class="adm-grid" style="grid-template-columns:1fr">
        <x-admin.field name="admin_name" label="Name" :value="auth()->user()->name" required />
        <x-admin.field name="admin_email" label="Email" type="email" :value="auth()->user()->email" required />
        <x-admin.field name="current_password" label="Current password" type="password" autocomplete="current-password" help="Only to change your password." />
        <x-admin.field name="new_password" label="New password" type="password" autocomplete="new-password" />
        <x-admin.field name="new_password_confirmation" label="Repeat new password" type="password" autocomplete="new-password" />
      </div>
    </section>
    <div class="adm-form__bar"><button class="adm-btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save Settings</button></div>
  </div>
</form>
@endsection
