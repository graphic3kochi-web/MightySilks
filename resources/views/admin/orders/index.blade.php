@extends('layouts.admin')

@section('title', 'Orders')
@section('crumb', 'Orders')

@section('content')
<div class="adm-head">
  <div>
    <h1>Orders</h1>
    <p>{{ $counts->sum() }} orders · {{ $counts['placed'] ?? 0 }} waiting to be packed</p>
  </div>
</div>

<section class="adm-card">
  <form class="adm-filters" method="get">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Order number, name, email or phone" aria-label="Search orders">
    <select name="status" aria-label="Status" onchange="this.form.submit()">
      <option value="">All statuses</option>
      @foreach (\App\Models\Order::STATUSES as $key => $label)
        <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }} ({{ $counts[$key] ?? 0 }})</option>
      @endforeach
    </select>
    <button class="adm-btn adm-btn--ghost" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
    @if (request()->hasAny(['q', 'status']))<a class="adm-btn adm-btn--ghost" href="{{ route('admin.orders.index') }}">Clear</a>@endif
  </form>
  @include('admin.orders.table')
  {{ $orders->links() }}
</section>
@endsection
