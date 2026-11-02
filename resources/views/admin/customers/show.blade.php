@extends('layouts.admin')

@section('title', $customer->name)
@section('crumb', $customer->name)

@section('content')
@php $spent = $orders->where('status', '!=', 'cancelled')->sum('total'); @endphp
<div class="adm-head">
  <div>
    <h1>{{ $customer->name }}</h1>
    <p>Customer since {{ $customer->created_at->format('d M Y') }}</p>
  </div>
  <div class="adm-head__actions">
    <span class="adm-badge adm-badge--{{ $customer->status }}">{{ ucfirst($customer->status) }}</span>
    <form method="post" action="{{ route('admin.customers.update', $customer) }}" data-confirm="{{ $customer->status === 'active' ? 'Block this customer? They won\'t be able to sign in.' : 'Reinstate this customer?' }}">
      @csrf @method('put')
      <input type="hidden" name="status" value="{{ $customer->status === 'active' ? 'blocked' : 'active' }}">
      <button class="adm-btn {{ $customer->status === 'active' ? 'adm-btn--danger' : '' }}" type="submit">
        <i class="fa-solid {{ $customer->status === 'active' ? 'fa-ban' : 'fa-rotate-left' }}"></i> {{ $customer->status === 'active' ? 'Block' : 'Reinstate' }}
      </button>
    </form>
  </div>
</div>

<div class="adm-detail">
  <section class="adm-card">
    <div class="adm-card__head"><span class="adm-card__icon"><i class="fa-solid fa-receipt"></i></span><div><h2 class="adm-card__title">Orders</h2><p class="adm-card__sub">{{ $orders->count() }} orders · {{ inr($spent) }} spent</p></div></div>
    @include('admin.orders.table')
  </section>
  <section class="adm-card">
    <div class="adm-card__head"><span class="adm-card__icon adm-card__icon--blue"><i class="fa-solid fa-user"></i></span><h2 class="adm-card__title">Details</h2></div>
    <dl class="adm-dl">
      <dt>Email</dt><dd><a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></dd>
      <dt>Phone</dt><dd>{{ $customer->phone ?: '—' }}</dd>
      <dt>Newsletter</dt><dd>{{ $customer->newsletter ? 'Subscribed' : 'No' }}</dd>
      <dt>Last sign-in</dt><dd>{{ $customer->last_login_at?->diffForHumans() ?? 'Never' }}</dd>
      <dt>Average order</dt><dd>{{ $orders->count() ? inr($spent / max($orders->where('status', '!=', 'cancelled')->count(), 1)) : '—' }}</dd>
    </dl>
  </section>
</div>
@endsection
