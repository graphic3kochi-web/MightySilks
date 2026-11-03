<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/** /my-profile: the signed-in shopper's details and password. Guests are sent to /login. */
class ProfileController extends Controller
{
    public function show(Request $request)
    {
        if (! $request->user()) {
            return redirect('login');
        }

        return view('account.profile', ['user' => $request->user(), 'tab' => $request->query('tab')]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'first_name' => 'required|string|max:60',
            'last_name' => 'nullable|string|max:60',
            'email' => ['required', 'email', 'max:120', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => 'nullable|string|max:30',
            'newsletter' => 'boolean',
        ], ['email.unique' => 'Another account already uses this email.']);

        $user->update([
            'name' => trim($data['first_name'].' '.($data['last_name'] ?? '')),
            'email' => strtolower($data['email']),
            'phone' => $data['phone'] ?? null,
            'newsletter' => $request->boolean('newsletter'),
        ]);
        if ($user->newsletter) {
            Subscriber::firstOrCreate(['email' => $user->email], ['source' => 'signup']);
        }

        return redirect()->route('profile')->with('profile_status', 'Your details have been saved.');
    }

    /** A new password needs the current one, so a left-open session can't take over the account. */
    public function password(Request $request)
    {
        $user = $request->user();
        $request->validateWithBag('password', [
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|max:100|confirmed',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages(['current_password' => 'Your current password isn\'t right.'])
                ->errorBag('password');
        }

        $user->update(['password' => $request->password]);
        $request->session()->regenerate();

        return redirect()->route('profile', ['tab' => 'password'])->with('password_status', 'Your password has been changed.');
    }
}
