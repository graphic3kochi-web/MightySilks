@extends('layouts.admin')

@section('title', 'Customers')
@section('crumb', 'Customers')

@section('content')
<div class="adm-head">
  <div>
    <h1>Customers</h1>
    <p>Shoppers with an account on the site</p>
  </div>
</div>

<section class="adm-card">
  <form class="adm-filters" method="get">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Name, email or phone" aria-label="Search customers">
    <select name="status" aria-label="Status" onchange="this.form.submit()">
      <option value="">Active &amp; blocked</option>
      <option value="active" @selected(request('status') === 'active')>Active</option>
      <option value="blocked" @selected(request('status') === 'blocked')>Blocked</option>
    </select>
    <button class="adm-btn adm-btn--ghost" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
  </form>
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Customer</th><th>Phone</th><th class="num">Orders</th><th class="num">Spent</th><th>Status</th><th>Joined</th></tr></thead>
      <tbody>
        @forelse ($customers as $customer)
          <tr>
            <td>
              <div class="adm-cell" style="min-width:200px">
                <span class="adm-avatar">{{ $customer->initials() }}</span>
                <span><a href="{{ route('admin.customers.show', $customer) }}">{{ $customer->name }}</a><br><span class="muted">{{ $customer->email }}</span></span>
              </div>
            </td>
            <td>{{ $customer->phone }}</td>
            <td class="num">{{ $customer->orders_count }}</td>
            <td class="num">{{ inr($customer->orders_sum_total ?? 0) }}</td>
            <td><span class="adm-badge adm-badge--{{ $customer->status }}">{{ ucfirst($customer->status) }}</span>@if ($customer->newsletter) <span class="adm-badge">Newsletter</span>@endif</td>
            <td>{{ $customer->created_at->format('d M Y') }}</td>
          </tr>
        @empty
          <tr><td colspan="6" class="adm-empty">No customers found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $customers->links() }}
</section>
@endsection
