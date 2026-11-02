@extends('layouts.site')

@section('title', 'Mighty Silks — Log In')

@section('scripts')
<script defer src="js/products.js"></script>
<script defer src="js/main.js"></script>
@endsection

@section('content')
<main>

    <!-- ============ Page title (as the cart page, Figma 281:2533 / 281:2534) ============ -->
    <div class="shop-hero">
      <h1 class="shop-hero__title">Log In</h1>
    </div>

    <!-- ============ Login ============ -->
    <!-- No Figma frame for this page: built in the checkout's style. js/main.js switches between
         email + password and phone + one-time code, shows or hides the password and, once the form
         is valid, signs in (there's no account backend, so it just remembers the email or phone)
         and goes back to the home page. -->
    <section class="login" aria-label="Log in" data-login>
      <form class="login__form" data-login-form novalidate>
        <p class="login__lead">Welcome back. Log in to see your orders, wishlist and saved details.</p>

        <div class="login__tabs" role="tablist" aria-label="Log in with">
          <button class="login__tab" type="button" role="tab" id="login-tab-email" aria-controls="login-panel-email" aria-selected="true" data-login-tab="email">Email</button>
          <button class="login__tab" type="button" role="tab" id="login-tab-phone" aria-controls="login-panel-phone" aria-selected="false" data-login-tab="phone">Phone Number</button>
        </div>

        <div class="login__panel" id="login-panel-email" role="tabpanel" aria-labelledby="login-tab-email" data-login-panel="email">
          <label class="checkout-field"><span>Email</span><input type="email" name="email" required autocomplete="email"></label>
          <label class="checkout-field"><span>Password</span>
            <span class="login__password">
              <input type="password" name="password" required minlength="6" autocomplete="current-password" data-login-password>
              <button class="login__show" type="button" aria-label="Show password" aria-pressed="false" data-login-show>
                <svg class="login__eye" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                <svg class="login__eye-off" viewBox="0 0 24 24" aria-hidden="true"><path d="M10.6 5.1A10 10 0 0 1 12 5c6.4 0 10 7 10 7a17 17 0 0 1-2.9 3.8M6.6 6.6A17 17 0 0 0 2 12s3.6 7 10 7a9.8 9.8 0 0 0 5.4-1.6"/><path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/><path d="M2 2l20 20"/></svg>
              </button>
            </span>
          </label>
        </div>

        <div class="login__panel" id="login-panel-phone" role="tabpanel" aria-labelledby="login-tab-phone" data-login-panel="phone" hidden>
          <div class="checkout-field">
            <label for="login-phone">Phone number</label>
            <span class="login__phone">
              <label class="visually-hidden" for="login-country">Country code</label>
              <select id="login-country" name="country-code" autocomplete="tel-country-code">
                <option value="+971" selected>+971</option>
                <option value="+91">+91</option>
              </select>
              <input id="login-phone" type="tel" name="phone" required inputmode="numeric" autocomplete="tel-national" pattern="[0-9 ]{7,12}" placeholder="50 123 4567">
            </span>
          </div>
          <div class="login__otp" data-login-otp hidden>
            <label class="checkout-field"><span>One-time code</span><input type="text" name="otp" inputmode="numeric" autocomplete="one-time-code" pattern="[0-9]{6}" maxlength="6" placeholder="6-digit code"></label>
            <button class="login__link login__resend" type="button" data-login-resend>Resend code</button>
          </div>
        </div>

        <div class="login__row">
          <label class="login__remember"><input type="checkbox" name="remember" checked> Remember me</label>
          <a class="login__link" href="#" data-login-forgot>Forgot password?</a>
        </div>

        <p class="login__status" role="alert" data-login-status></p>

        <button class="pdp-btn pdp-btn--solid login__submit" type="submit" data-login-submit>Log In</button>

        <p class="login__divider"><span>or</span></p>
        <div class="login__social">
          <button class="login__social-btn" type="button" data-login-social="Google">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.4h6.5a5.5 5.5 0 0 1-2.4 3.6v3h3.9c2.2-2.1 3.5-5.1 3.5-8.7z"/><path fill="#34A853" d="M12 24c3.2 0 6-1.1 8-2.9l-3.9-3c-1.1.7-2.5 1.2-4.1 1.2-3.1 0-5.8-2.1-6.7-5H1.3v3.1A12 12 0 0 0 12 24z"/><path fill="#FBBC05" d="M5.3 14.3a7.2 7.2 0 0 1 0-4.6V6.6H1.3a12 12 0 0 0 0 10.8z"/><path fill="#EA4335" d="M12 4.8c1.8 0 3.3.6 4.6 1.8l3.4-3.4A12 12 0 0 0 1.3 6.6l4 3.1c.9-2.8 3.6-4.9 6.7-4.9z"/></svg>
            Continue with Google
          </button>
          <button class="login__social-btn" type="button" data-login-social="Apple">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#000" d="M16.4 12.7c0-2.6 2.1-3.8 2.2-3.9-1.2-1.8-3.1-2-3.7-2-1.6-.2-3.1.9-3.9.9-.8 0-2-.9-3.4-.9-1.7 0-3.3 1-4.2 2.6-1.8 3.1-.5 7.7 1.3 10.2.8 1.2 1.8 2.6 3.1 2.6 1.3-.1 1.7-.8 3.3-.8 1.5 0 1.9.8 3.3.8 1.4 0 2.2-1.3 3-2.5 1-1.4 1.4-2.8 1.4-2.9-.1 0-2.4-.9-2.4-4.1zM13.9 5.1c.7-.9 1.2-2 1-3.1-1 0-2.2.7-2.9 1.5-.6.7-1.2 1.9-1 3 1.1.1 2.2-.6 2.9-1.4z"/></svg>
            Continue with Apple
          </button>
        </div>

        <p class="login__divider"><span>New to Mighty Silks?</span></p>
        <a class="pdp-btn pdp-btn--outline login__create" href="signup">Create Account</a>
      </form>
    </section>

  </main>
@endsection
