<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Login · {{ \App\Models\Setting::get('store_name') }}</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('admin-assets/admin.css') }}">
</head>
<body class="adm">
<main class="adm-login">
  <form class="adm-login__card" method="post" action="{{ route('admin.login') }}">
    @csrf
    <h1>{{ \App\Models\Setting::get('store_name') }}</h1>
    <p>Sign in to the control panel</p>
    @if ($errors->any())
      <div class="adm-flash adm-flash--error" role="alert"><i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}</div>
    @endif
    <div class="adm-field">
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
    </div>
    <div class="adm-field">
      <label for="password">Password</label>
      <input id="password" type="password" name="password" required autocomplete="current-password">
    </div>
    <label class="adm-check"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
    <button class="adm-btn" type="submit"><i class="fa-solid fa-right-to-bracket"></i> Sign in</button>
  </form>
</main>
</body>
</html>
