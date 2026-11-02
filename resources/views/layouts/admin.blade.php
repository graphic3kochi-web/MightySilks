<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') · {{ \App\Models\Setting::get('store_name') }} Admin</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('admin-assets/admin.css') }}">
@stack('head')
</head>
<body class="adm">
@php
  $nav = [
    ['Dashboard', 'admin.dashboard', 'fa-table-cells-large', null],
    'Store',
    ['Orders', 'admin.orders.index', 'fa-bag-shopping', $pending['orders']],
    ['Products', 'admin.products.index', 'fa-shirt', null],
    ['Collections', 'admin.collections.index', 'fa-layer-group', null],
    ['Customers', 'admin.customers.index', 'fa-users', null],
    ['Coupons', 'admin.coupons.index', 'fa-ticket', null],
    ['Reviews', 'admin.reviews.index', 'fa-star', $pending['reviews']],
    'Website Content',
    ['Blog Posts', 'admin.blogs.index', 'fa-newspaper', null],
    ['Careers', 'admin.careers.index', 'fa-briefcase', null],
    ['Applications', 'admin.applications.index', 'fa-file-lines', $pending['applications']],
    ['Enquiries', 'admin.enquiries.index', 'fa-envelope-open-text', $pending['enquiries']],
    ['Subscribers', 'admin.subscribers.index', 'fa-paper-plane', null],
    ['Settings', 'admin.settings.edit', 'fa-gear', null],
  ];
  $waiting = array_sum($pending);
@endphp

<aside class="adm-side" id="adm-side">
  {{-- The storefront's white logo (as in the home page hero); collapsed, only the mark shows. --}}
  <a class="adm-brand" href="{{ route('admin.dashboard') }}" aria-label="{{ \App\Models\Setting::get('store_name') }} control panel">
    <span class="adm-logo" aria-hidden="true">
      <span class="adm-logo__mark"><img src="{{ asset('assets/hero/logo-mark.png') }}" alt=""></span>
      <span class="adm-brand__text">
        <img class="adm-logo__wordmark" src="{{ asset('assets/hero/logo-mighty.svg') }}" alt="">
        <span class="adm-logo__silks">Silks</span>
      </span>
    </span>
  </a>
  <nav class="adm-nav" aria-label="Admin">
    @foreach ($nav as $item)
      @if (is_string($item))
        <p class="adm-nav__label">{{ $item }}</p>
      @else
        @php [$label, $route, $icon, $count] = $item; $section = \Illuminate\Support\Str::beforeLast($route, '.'); @endphp
        <a class="adm-nav__link {{ request()->routeIs($route === 'admin.dashboard' ? $route : $section.'.*') ? 'is-active' : '' }}" href="{{ route($route) }}">
          <i class="fa-solid {{ $icon }}" aria-hidden="true"></i><span>{{ $label }}</span>
          @if ($count)<b class="adm-nav__count">{{ $count }}</b>@endif
        </a>
      @endif
    @endforeach
  </nav>
  <form class="adm-side__foot" method="post" action="{{ route('admin.logout') }}">
    @csrf
    <button class="adm-nav__link adm-nav__link--logout" type="submit"><i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i><span>Log out</span></button>
  </form>
</aside>
<div class="adm-scrim" data-side-close></div>

<div class="adm-main">
  <header class="adm-top">
    <button class="adm-burger" type="button" aria-label="Menu" aria-controls="adm-side" data-side-toggle><i class="fa-solid fa-bars"></i></button>
    <nav class="adm-crumbs" aria-label="Breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
      <span>@yield('crumb', 'Overview')</span>
    </nav>
    <div class="adm-top__actions">
      <a class="adm-pill" href="{{ route('admin.orders.index') }}"><i class="fa-solid fa-bag-shopping"></i> Orders</a>
      <a class="adm-btn adm-btn--ghost adm-hide-sm" href="{{ url('/') }}" target="_blank" rel="noopener"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Site</a>
      <a class="adm-bell" href="{{ route('admin.dashboard') }}#attention" aria-label="{{ $waiting }} items waiting">
        <i class="fa-solid fa-bell"></i>@if ($waiting)<b>{{ $waiting > 9 ? '9+' : $waiting }}</b>@endif
      </a>
      <details class="adm-user">
        <summary>
          <span class="adm-avatar">{{ auth()->user()->initials() }}</span>
          <span class="adm-user__who adm-hide-sm"><strong>{{ auth()->user()->name }}</strong><small>{{ auth()->user()->email }}</small></span>
          <i class="fa-solid fa-chevron-down adm-hide-sm" aria-hidden="true"></i>
        </summary>
        <div class="adm-user__menu">
          <a href="{{ route('admin.settings.edit') }}"><i class="fa-solid fa-gear"></i> Settings</a>
          <a href="{{ url('/') }}" target="_blank" rel="noopener"><i class="fa-solid fa-store"></i> Storefront</a>
          <form method="post" action="{{ route('admin.logout') }}">@csrf<button type="submit"><i class="fa-solid fa-right-from-bracket"></i> Log out</button></form>
        </div>
      </details>
    </div>
  </header>

  <main class="adm-content">
    @if (session('status'))
      <div class="adm-flash" role="status"><i class="fa-solid fa-circle-check"></i> {{ session('status') }}</div>
    @endif
    @if ($errors->any())
      <div class="adm-flash adm-flash--error" role="alert"><i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}</div>
    @endif
    @yield('content')
  </main>
</div>

<script>
// Sidebar drawer on small screens; confirm before destructive buttons (data-confirm).
document.querySelectorAll('[data-side-toggle], [data-side-close]').forEach((el) => el.addEventListener('click', () => document.body.classList.toggle('adm-side-open')))
document.addEventListener('submit', (e) => {
  const message = e.target.dataset.confirm
  if (message && !confirm(message)) e.preventDefault()
})
</script>
@stack('scripts')
</body>
</html>
