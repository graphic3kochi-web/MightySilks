<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Collection;
use App\Models\Coupon;
use App\Models\JobOpening;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * The store as the static site had it: the catalogue (js/products.js + every shop page's
     * grid, from database/seeders/data), the blog, open roles, the site's two coupon codes, and
     * an admin account.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@mightysilks.ae'], [
            'name' => 'Super Admin',
            'password' => 'password',
            'is_admin' => true,
        ]);

        Setting::put(Setting::DEFAULTS);

        Coupon::updateOrCreate(['code' => 'NEW10'], ['description' => 'Cart drawer offer: 10% off', 'percent' => 10, 'is_featured' => true]);
        Coupon::updateOrCreate(['code' => 'WELCOME10'], ['description' => 'Product page welcome offer: 10% off', 'percent' => 10]);

        $products = [];
        foreach ($this->data('products') as $row) {
            $products[$row['code']] = Product::updateOrCreate(['code' => $row['code']], $row)->id;
        }
        foreach ($this->data('collections') as $slug => $collection) {
            $model = Collection::updateOrCreate(['slug' => $slug], ['name' => $collection['name']]);
            $model->products()->sync(collect($collection['codes'])->unique()->values()
                ->mapWithKeys(fn ($code, $i) => [$products[$code] => ['position' => $i]])->all());
        }

        foreach ($this->data('blogs') as $slug => $post) {
            Blog::updateOrCreate(['slug' => $slug], [
                'title' => $post['title'],
                'tag' => $post['tag'],
                'category' => $post['category'],
                'published_on' => $post['date'],
                'read_time' => $post['readTime'],
                'image' => $post['image'],
                'alt' => $post['alt'] ?? null,
                'excerpt' => $post['excerpt'],
                'shop_label' => $post['shop']['label'] ?? null,
                'shop_href' => $post['shop']['href'] ?? null,
                'body' => $post['body'],
            ]);
        }

        $careers = $this->data('jobs');
        Setting::put(['job_offer' => implode("\n", $careers['offer'])]);
        foreach (array_values($careers['jobs']) as $i => $job) {
            JobOpening::updateOrCreate(['slug' => array_keys($careers['jobs'])[$i]], [
                'title' => $job['title'],
                'department' => $job['department'],
                'location' => $job['location'],
                'type' => $job['type'],
                'experience' => $job['experience'],
                'summary' => $job['summary'],
                'responsibilities' => $job['responsibilities'],
                'requirements' => $job['requirements'],
                'offer' => $job['offer'] ?? null,
                'position' => $i,
            ]);
        }
    }

    private function data(string $name): array
    {
        return json_decode(file_get_contents(database_path("seeders/data/$name.json")), true);
    }
}
