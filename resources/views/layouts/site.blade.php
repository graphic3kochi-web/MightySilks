<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@yield('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title')</title>
<link rel="stylesheet" href="css/styles.css">
<script>document.documentElement.classList.add('js')</script>
{{-- Store rules js/main.js reads: the featured coupon, shipping rates and the signed-in shopper. --}}
<script>window.SHOP = @json($shop)</script>
@yield('scripts')
</head>
<body>
<div class="page">

@include('partials.search-panel')

@hasSection('header')
@yield('header')
@else
@include('partials.shop-header', ['active' => trim($__env->yieldContent('active'))])
@endif

@yield('content')

@include('partials.footer')

</div>

@include('partials.account-menu')

@include('partials.cart-panel')

@yield('after')
</body>
</html>
