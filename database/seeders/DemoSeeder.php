<?php

namespace Database\Seeders;

use App\Models\Enquiry;
use App\Models\JobApplication;
use App\Models\JobOpening;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Sample activity (customers, orders, reviews, enquiries…) over the last 12 weeks, so the admin
 * dashboard has something to show. Not for production:  php artisan db:seed --class=DemoSeeder
 */
class DemoSeeder extends Seeder
{
    private const FIRST = ['Aisha', 'Priya', 'Lakshmi', 'Fatima', 'Anjali', 'Meera', 'Divya', 'Sana', 'Kavya', 'Reshma', 'Nisha', 'Asha', 'Neha', 'Shreya', 'Mariam', 'Deepa'];

    private const LAST = ['Nair', 'Menon', 'Khan', 'Pillai', 'Sharma', 'Iyer', 'Thomas', 'Joseph', 'Rahman', 'Varma', 'Kurian', 'Shetty'];

    private const CITIES = [['Kochi', 'Kerala', '682016'], ['Chennai', 'Tamil Nadu', '600017'], ['Bengaluru', 'Karnataka', '560001'], ['Mumbai', 'Maharashtra', '400050'], ['Thiruvananthapuram', 'Kerala', '695001'], ['Hyderabad', 'Telangana', '500034']];

    public function run(): void
    {
        mt_srand(2026);
        $products = Product::all();
        $shipping = Setting::shipping();

        $customers = collect(range(1, 48))->map(function ($i) {
            $first = self::FIRST[array_rand(self::FIRST)];
            $last = self::LAST[array_rand(self::LAST)];
            $joined = Carbon::now()->subDays(mt_rand(0, 84))->subMinutes(mt_rand(0, 1440));

            $user = User::create([
                'name' => "$first $last",
                'email' => Str::lower("$first.$last.$i@example.com"),
                'phone' => '+91 9'.mt_rand(100000000, 999999999),
                'password' => 'password',
                'newsletter' => mt_rand(0, 2) === 0,
                'status' => $i % 17 === 0 ? 'blocked' : 'active',
            ]);
            $user->forceFill(['created_at' => $joined, 'updated_at' => $joined])->save();

            return $user;
        });

        foreach (range(1, 140) as $i) {
            $customer = mt_rand(0, 4) ? $customers->random() : null;
            $placed = Carbon::now()->subDays((int) floor(84 * (mt_rand(0, 1000) / 1000) ** 1.4))->subMinutes(mt_rand(0, 1440));
            $lines = $products->random(mt_rand(1, 3));
            $subtotal = 0;
            $items = $lines->map(function (Product $p) use (&$subtotal) {
                $qty = mt_rand(1, 10) > 8 ? 2 : 1;
                $subtotal += $p->price * $qty;

                return ['product_id' => $p->id, 'product_code' => $p->code, 'name' => $p->title, 'image' => $p->image(), 'price' => $p->price, 'qty' => $qty];
            });
            $coupon = mt_rand(0, 3) === 0 ? 'NEW10' : null;
            $discount = $coupon ? round($subtotal * 0.1) : 0;
            $express = mt_rand(0, 4) === 0;
            $ship = $express ? $shipping['express'] : ($subtotal - $discount >= $shipping['freeFrom'] ? 0 : $shipping['standard']);
            $age = $placed->diffInDays(now());
            $status = match (true) {
                $i % 23 === 0 => 'cancelled',
                $age > 7 => 'delivered',
                $age > 2 => 'shipped',
                $age > 1 => 'packed',
                default => 'placed',
            };
            [$city, $state, $pin] = self::CITIES[array_rand(self::CITIES)];
            $name = $customer ? explode(' ', $customer->name, 2) : [self::FIRST[array_rand(self::FIRST)], self::LAST[array_rand(self::LAST)]];
            $payment = ['upi' => 'UPI', 'card' => 'Card ending '.mt_rand(1000, 9999), 'cod' => 'Cash on Delivery'];
            $method = array_rand($payment);

            $order = Order::create([
                'number' => 'MS'.str_pad((string) (100000 + $i * 37), 6, '0', STR_PAD_LEFT),
                'user_id' => $customer?->id,
                'status' => $status,
                'payment_method' => $method,
                'payment_label' => $payment[$method],
                'payment_status' => $status === 'cancelled' ? 'refunded' : ($method === 'cod' && $status !== 'delivered' ? 'pending' : 'paid'),
                'email' => $customer?->email ?? Str::lower("{$name[0]}.$i@example.com"),
                'phone' => $customer?->phone ?? '+91 98'.mt_rand(10000000, 99999999),
                'first_name' => $name[0],
                'last_name' => $name[1],
                'address' => mt_rand(10, 220).', '.['MG Road', 'Marine Drive', 'Anna Salai', 'Brigade Road', 'Linking Road'][mt_rand(0, 4)],
                'city' => $city,
                'state' => $state,
                'postal_code' => $pin,
                'country' => 'India',
                'shipping_method' => $express ? 'express' : 'standard',
                'shipping_label' => $express ? 'Express Shipping' : 'Standard Shipping',
                'coupon_code' => $coupon,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping' => $ship,
                'total' => $subtotal - $discount + $ship,
                'packed_at' => in_array($status, ['packed', 'shipped', 'delivered']) ? $placed->copy()->addDay() : null,
                'shipped_at' => in_array($status, ['shipped', 'delivered']) ? $placed->copy()->addDays(2) : null,
                'delivered_at' => $status === 'delivered' ? $placed->copy()->addDays($express ? 3 : 7) : null,
            ]);
            $order->forceFill(['created_at' => $placed, 'updated_at' => $placed])->save();
            $order->items()->createMany($items->all());
        }

        $reviews = ['Absolutely stunning, the colour is even better in person.', 'Lovely fabric and the zari work is beautiful.', 'Arrived quickly and was packed with care.', 'Perfect for my sister\'s wedding. Got so many compliments!', 'Good quality but the blouse piece was shorter than expected.'];
        foreach (range(1, 26) as $i) {
            Review::create([
                'product_id' => $products->random()->id,
                'rating' => [5, 5, 4, 5, 3][$i % 5],
                'title' => ['Beautiful', 'Loved it', 'Great service', 'Gorgeous', 'Nice'][$i % 5],
                'body' => $reviews[$i % 5],
                'name' => self::FIRST[$i % count(self::FIRST)],
                'status' => $i < 8 ? 'pending' : 'approved',
            ])->forceFill(['created_at' => now()->subDays(mt_rand(0, 60))])->save();
        }

        foreach (range(1, 9) as $i) {
            Enquiry::create([
                'name' => self::FIRST[$i].' '.self::LAST[$i],
                'company' => ['Lulu Events', 'Grand Hyatt Kochi', 'Tata Consultancy', 'Malabar Weddings', null][$i % 5],
                'email' => "enquiry$i@example.com",
                'phone' => '+971 50 '.mt_rand(1000000, 9999999),
                'order_type' => ['Corporate Gifting', 'Wedding / Family Event', 'Uniforms', 'Retail / Resale'][$i % 4],
                'quantity' => [25, 40, 120, 60, 15][$i % 5],
                'budget' => ['₹2,000 – ₹5,000', '₹5,000 – ₹10,000', 'Under ₹2,000'][$i % 3],
                'message' => 'Looking for matching sarees for our team. Please share a quote and catalogue.',
                'status' => $i < 5 ? 'new' : 'quoted',
            ])->forceFill(['created_at' => now()->subDays(mt_rand(0, 30))])->save();
        }

        $openings = JobOpening::all();
        foreach (range(1, 11) as $i) {
            $job = $openings->random();
            JobApplication::create([
                'job_opening_id' => $job->id,
                'position' => $job->title,
                'name' => self::FIRST[$i].' '.self::LAST[$i % 12],
                'email' => "applicant$i@example.com",
                'phone' => '+971 55 '.mt_rand(1000000, 9999999),
                'message' => 'I would love to join the Mighty Silks team.',
                'cv_path' => 'cvs/sample.pdf',
                'cv_name' => 'CV.pdf',
                'status' => $i < 6 ? 'new' : 'shortlisted',
            ])->forceFill(['created_at' => now()->subDays(mt_rand(0, 40))])->save();
        }

        foreach (range(1, 64) as $i) {
            Subscriber::create(['email' => "reader$i@example.com", 'source' => ['blog', 'signup'][$i % 2]])
                ->forceFill(['created_at' => now()->subDays(mt_rand(0, 84))])->save();
        }
    }
}
