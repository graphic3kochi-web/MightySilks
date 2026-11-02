<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Mail\SignupCode;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

/** Shopper accounts for /login / /signup (session based, so the pages know who's in). */
class AccountController extends Controller
{
    /**
     * Sign up, step 1: checks the details and emails a 6-digit code (valid 10 minutes). No account
     * exists yet; the details wait in the cache (password already hashed) until step 2. Sending
     * again (Resend code) replaces the code.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'email' => 'required|email|max:120|unique:users,email',
            'phone' => 'required|string|max:30',
            'password' => 'required|string|min:6|max:100',
            'newsletter' => 'boolean',
        ], ['email.unique' => 'An account with this email already exists. Please log in instead.']);

        $email = strtolower($data['email']);
        $code = (string) random_int(100000, 999999);
        Cache::put($this->signupKey($email), [
            'hash' => Hash::make($code),
            'tries' => 0,
            'user' => [
                'name' => "{$data['first_name']} {$data['last_name']}",
                'email' => $email,
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'newsletter' => $data['newsletter'] ?? false,
            ],
        ], now()->addMinutes(10));

        try {
            Mail::to($email)->send(new SignupCode($data['first_name'], $code));
        } catch (\Throwable $e) {
            report($e);
            throw ValidationException::withMessages(['email' => 'We couldn\'t send the code to this email. Please check the address and try again.']);
        }

        // With mail going only to the log (no SMTP set up), show the code so signing up still works.
        return ['ok' => true] + (config('mail.default') === 'log' ? ['debug_code' => $code] : []);
    }

    /** Sign up, step 2: the emailed code (5 tries) creates the account and signs the shopper in. */
    public function verifyRegistration(Request $request)
    {
        $request->validate(['email' => 'required|email', 'otp' => 'required|digits:6']);
        $key = $this->signupKey($request->email);
        $pending = Cache::get($key);

        if (! $pending || $pending['tries'] >= 5) {
            Cache::forget($key);
            throw ValidationException::withMessages(['otp' => 'That code has expired. Please send a new one.']);
        }
        if (! Hash::check($request->otp, $pending['hash'])) {
            Cache::put($key, [...$pending, 'tries' => $pending['tries'] + 1], now()->addMinutes(10));
            throw ValidationException::withMessages(['otp' => 'That code isn\'t right. Please check it and try again.']);
        }

        Cache::forget($key);
        if (User::where('email', $pending['user']['email'])->exists()) {
            throw ValidationException::withMessages(['email' => 'An account with this email already exists. Please log in instead.']);
        }
        $user = User::create($pending['user']);
        if ($user->newsletter) {
            Subscriber::firstOrCreate(['email' => $user->email], ['source' => 'signup']);
        }

        return $this->signIn($request, $user, true);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required|string']);

        if (! Auth::attempt([...$credentials, 'status' => 'active'], $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'That email and password don\'t match an account.']);
        }

        return $this->signIn($request, Auth::user(), $request->boolean('remember'));
    }

    /** Phone login, step 1: a 6-digit code for the account with this number, valid 10 minutes. */
    public function sendCode(Request $request)
    {
        $request->validate(['phone' => 'required|string|max:30']);
        $user = $this->userByPhone($request->phone);
        if (! $user) {
            throw ValidationException::withMessages(['phone' => 'No account uses this phone number. Please create an account first.']);
        }

        $code = (string) random_int(100000, 999999);
        Cache::put($this->codeKey($request->phone), ['hash' => Hash::make($code), 'user' => $user->id, 'tries' => 0], now()->addMinutes(10));
        // No SMS provider yet: the code goes to the log (storage/logs/laravel.log).
        Log::info("Login code for {$request->phone}: $code");

        return ['ok' => true] + (config('app.debug') ? ['debug_code' => $code] : []);
    }

    /** Phone login, step 2: the code from step 1 (5 tries). */
    public function verifyCode(Request $request)
    {
        $request->validate(['phone' => 'required|string|max:30', 'otp' => 'required|digits:6']);
        $key = $this->codeKey($request->phone);
        $pending = Cache::get($key);

        if (! $pending || $pending['tries'] >= 5) {
            Cache::forget($key);
            throw ValidationException::withMessages(['otp' => 'That code has expired. Please send a new one.']);
        }
        if (! Hash::check($request->otp, $pending['hash'])) {
            Cache::put($key, [...$pending, 'tries' => $pending['tries'] + 1], now()->addMinutes(10));
            throw ValidationException::withMessages(['otp' => 'That code isn\'t right. Please check it and try again.']);
        }

        Cache::forget($key);
        $user = User::where('status', 'active')->findOrFail($pending['user']);
        Auth::login($user, $request->boolean('remember'));

        return $this->signIn($request, $user, $request->boolean('remember'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function signIn(Request $request, User $user, bool $remember)
    {
        if (! Auth::check()) {
            Auth::login($user, $remember);
        }
        $request->session()->regenerate();
        $user->forceFill(['last_login_at' => now()])->save();

        return [
            'ok' => true,
            'name' => strtok($user->name, ' '),
            'admin' => $user->is_admin,
            'redirect' => $user->is_admin ? route('admin.dashboard') : url('/'),
        ];
    }

    private function userByPhone(string $phone): ?User
    {
        $key = User::phoneKey($phone);

        return strlen($key) < 7 ? null : User::where('status', 'active')->whereNotNull('phone')
            ->where('phone', 'like', '%'.substr($key, -4))->get()
            ->first(fn (User $u) => User::phoneKey($u->phone) === $key);
    }

    private function codeKey(string $phone): string
    {
        return 'login-code:'.User::phoneKey($phone);
    }

    private function signupKey(string $email): string
    {
        return 'signup-code:'.sha1(strtolower(trim($email)));
    }
}
