<!-- Account menu: opened by the header account button, placed under it by js/main.js. -->
<div class="account-menu" id="account-menu" hidden>
@auth
  <p class="account-menu__hello">Hi, {{ strtok(auth()->user()->name, ' ') }}<small>{{ auth()->user()->email }}</small></p>
  @if (auth()->user()->is_admin)
  <a class="account-menu__btn account-menu__btn--primary" href="{{ route('admin.dashboard') }}">Admin Panel</a>
  @else
  <a class="account-menu__btn account-menu__btn--primary" href="my-orders.html">My Orders</a>
  @endif
  <form method="post" action="{{ route('logout') }}">
    @csrf
    <button class="account-menu__btn account-menu__btn--secondary" type="submit">Log out</button>
  </form>
@else
  <a class="account-menu__btn account-menu__btn--primary" href="login.html">Log in</a>
  <a class="account-menu__btn account-menu__btn--secondary" href="signup.html">Create Account</a>
@endauth
</div>
