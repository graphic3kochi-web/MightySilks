<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index()
    {
        return view('admin.coupons.index', ['coupons' => Coupon::orderByDesc('is_featured')->orderBy('code')->get()]);
    }

    public function create()
    {
        return view('admin.coupons.form', ['coupon' => new Coupon(['percent' => 10, 'is_active' => true])]);
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.form', ['coupon' => $coupon]);
    }

    public function store(Request $request)
    {
        $this->save($request, new Coupon);

        return redirect()->route('admin.coupons.index')->with('status', 'Coupon added.');
    }

    public function update(Request $request, Coupon $coupon)
    {
        $this->save($request, $coupon);

        return redirect()->route('admin.coupons.index')->with('status', "{$coupon->code} saved.");
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('status', "{$coupon->code} deleted.");
    }

    /** Only one coupon is featured (offered in the cart drawer) at a time. */
    private function save(Request $request, Coupon $coupon): void
    {
        $request->merge(['code' => strtoupper((string) $request->code)]);
        $data = $request->validate([
            'code' => ['required', 'alpha_num', 'max:40', Rule::unique('coupons', 'code')->ignore($coupon->id)],
            'description' => 'nullable|string|max:255',
            'percent' => 'required|integer|min:1|max:90',
            'min_subtotal' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);
        $coupon->fill([...$data, 'min_subtotal' => $data['min_subtotal'] ?? 0])->save();
        if ($coupon->is_featured) {
            Coupon::whereKeyNot($coupon->id)->update(['is_featured' => false]);
        }
    }
}
