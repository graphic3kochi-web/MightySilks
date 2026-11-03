@extends('layouts.site')

@section('title', 'Mighty Silks — My Profile')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <div class="shop-hero">
      <h1 class="shop-hero__title">My Profile</h1>
    </div>

    <!-- The signed-in shopper's account (Shop\ProfileController): a side menu, then either their
         details (?tab omitted) or the password form (?tab=password). Plain form posts, no script
         beyond the password eye buttons in js/main.js. -->
    @php($onPassword = $tab === 'password')
    <section class="profile" aria-label="My profile">
      <nav class="profile__nav" aria-label="Account">
        <a class="profile__link" href="my-profile" @if (! $onPassword) aria-current="page" @endif>
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/></svg>User info
        </a>
        <a class="profile__link" href="my-profile?tab=password" @if ($onPassword) aria-current="page" @endif>
          <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="10" width="16" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>Change Password
        </a>
        <a class="profile__link" href="my-orders">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 7h14l-1 14H6z"/><path d="M9 7a3 3 0 0 1 6 0"/></svg>My Orders
        </a>
        <a class="profile__link" href="track-order">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h11v10H3zM14 10h4l3 3v4h-7"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>Track Order
        </a>
        <form class="profile__logout" method="post" action="{{ route('logout') }}">
          @csrf
          <button class="profile__link" type="submit">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 4h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-5"/><path d="M10 8l-4 4 4 4M6 12h10"/></svg>Log out
          </button>
        </form>
      </nav>

      <div class="profile__main">
        <div class="profile__head">
          <span class="profile__avatar" aria-hidden="true">{{ $user->initials() }}</span>
          <div>
            <h2 class="profile__name">{{ $user->name }}</h2>
            <p class="profile__meta">Member since {{ $user->created_at->format('M Y') }}</p>
          </div>
        </div>

        @if (! $onPassword)
          @php([$first, $last] = array_pad(explode(' ', $user->name, 2), 2, ''))
          <form class="profile__form" method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            <div class="profile__grid">
              <label class="profile__field"><span>First Name</span><input type="text" name="first_name" value="{{ old('first_name', $first) }}" required maxlength="60" autocomplete="given-name"></label>
              <label class="profile__field"><span>Last Name</span><input type="text" name="last_name" value="{{ old('last_name', $last) }}" maxlength="60" autocomplete="family-name"></label>
              <label class="profile__field"><span>Email Address</span><input type="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="120" autocomplete="email"></label>
              <label class="profile__field"><span>Phone Number</span><input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" maxlength="30" autocomplete="tel"></label>
            </div>

            <input type="hidden" name="newsletter" value="0">
            <label class="login__remember profile__check"><input type="checkbox" name="newsletter" value="1" @checked(old('newsletter', $user->newsletter))> <span>Email me about new arrivals and offers</span></label>

            @if ($errors->any())
              <p class="login__status" role="alert">{{ $errors->first() }}</p>
            @elseif (session('profile_status'))
              <p class="login__status is-success" role="status">{{ session('profile_status') }}</p>
            @endif

            <button class="pdp-btn pdp-btn--solid profile__save" type="submit">Save Changes</button>
          </form>
        @else
          <form class="profile__form" method="post" action="{{ route('profile.password') }}">
            @csrf
            @method('PUT')
            <div class="profile__grid">
              @foreach (['current_password' => 'Current Password', 'password' => 'New Password', 'password_confirmation' => 'Confirm New Password'] as $field => $label)
                <label class="profile__field @if ($field === 'current_password') profile__field--wide @endif"><span>{{ $label }}</span>
                  <span class="login__password">
                    <input type="password" name="{{ $field }}" required @if ($field !== 'current_password') minlength="6" @endif autocomplete="{{ $field === 'current_password' ? 'current-password' : 'new-password' }}">
                    <button class="login__show" type="button" aria-label="Show password" aria-pressed="false" data-login-show>
                      <svg class="login__eye" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                      <svg class="login__eye-off" viewBox="0 0 24 24" aria-hidden="true"><path d="M10.6 5.1A10 10 0 0 1 12 5c6.4 0 10 7 10 7a17 17 0 0 1-2.9 3.8M6.6 6.6A17 17 0 0 0 2 12s3.6 7 10 7a9.8 9.8 0 0 0 5.4-1.6"/><path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/><path d="M2 2l20 20"/></svg>
                    </button>
                  </span>
                </label>
              @endforeach
            </div>

            @if ($errors->password->any())
              <p class="login__status" role="alert">{{ $errors->password->first() }}</p>
            @elseif (session('password_status'))
              <p class="login__status is-success" role="status">{{ session('password_status') }}</p>
            @endif

            <button class="pdp-btn pdp-btn--solid profile__save" type="submit">Update Password</button>
          </form>
        @endif
      </div>
    </section>

  </main>
@endsection
