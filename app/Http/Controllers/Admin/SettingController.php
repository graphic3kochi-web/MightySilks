<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings', [
            'settings' => collect(array_keys(Setting::DEFAULTS + ['job_offer' => '']))->mapWithKeys(fn ($key) => [$key => Setting::get($key)]),
        ]);
    }

    /** Store settings, plus the signed-in admin's own name, email and password. */
    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'store_name' => 'required|string|max:80',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:40',
            'free_shipping_from' => 'required|numeric|min:0',
            'standard_shipping' => 'required|numeric|min:0',
            'express_shipping' => 'required|numeric|min:0',
            'job_offer' => 'nullable|string|max:2000',
            'admin_name' => 'required|string|max:80',
            'admin_email' => 'required|email|unique:users,email,'.$user->id,
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        Setting::put(collect($data)->only(['store_name', 'contact_email', 'contact_phone', 'free_shipping_from', 'standard_shipping', 'express_shipping', 'job_offer'])->all());
        $user->fill(['name' => $data['admin_name'], 'email' => $data['admin_email']]);
        if ($data['new_password'] ?? null) {
            $user->password = Hash::make($data['new_password']);
        }
        $user->save();

        return back()->with('status', 'Settings saved.');
    }
}
