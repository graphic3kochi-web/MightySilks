<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The shop: catalogue, collections (one per shop page), orders, coupons and reviews.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code', 40)->unique(); // the storefront id: product.html?p=<code>
            $table->string('title');
            $table->string('page_title')->nullable(); // product page heading, when it differs from the card
            $table->decimal('price', 10, 2);
            $table->string('sku', 60)->nullable();
            $table->string('alt')->nullable();
            $table->string('category', 40)->index();
            // Space-separated filter slugs, as the shop filters read them (data-color etc.).
            $table->string('color')->nullable();
            $table->string('pattern')->nullable();
            $table->string('fabric')->nullable();
            $table->string('blouse', 10)->nullable();
            $table->string('occasion')->nullable();
            $table->json('gallery'); // product page photos, first is the main one
            $table->json('card_layers'); // shop card photo layers: [{src, alt, style, fill}]
            $table->string('hover_image')->nullable();
            $table->unsignedInteger('stock')->default(10);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 80)->unique(); // the shop page: <slug>.html
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('collection_product', function (Blueprint $table) {
            $table->foreignId('collection_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('position')->default(0);
            $table->primary(['collection_id', 'product_id']);
        });

        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 40)->unique();
            $table->string('description')->nullable();
            $table->unsignedTinyInteger('percent');
            $table->decimal('min_subtotal', 10, 2)->default(0);
            $table->unsignedInteger('max_uses')->nullable();
            $table->unsignedInteger('used_count')->default(0);
            $table->date('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false); // the one offered in the cart drawer
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number', 20)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status', 20)->default('placed')->index(); // placed | packed | shipped | delivered | cancelled
            $table->string('payment_method', 20);
            $table->string('payment_label');
            $table->string('payment_status', 20)->default('pending'); // pending | paid | refunded
            $table->string('email');
            $table->string('phone', 30);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->string('address_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postal_code', 20);
            $table->string('country');
            $table->string('shipping_method', 20);
            $table->string('shipping_label');
            $table->string('coupon_code', 40)->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('shipping', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->text('note')->nullable();
            $table->timestamp('packed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_code', 40);
            $table->string('name');
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('qty');
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->string('title')->nullable();
            $table->text('body');
            $table->string('name');
            $table->string('status', 20)->default('pending')->index(); // pending | approved | rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('collection_product');
        Schema::dropIfExists('collections');
        Schema::dropIfExists('products');
    }
};
