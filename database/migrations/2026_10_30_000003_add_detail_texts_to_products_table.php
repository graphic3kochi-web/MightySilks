<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The product page accordion texts (Product Details, Design Details, Material & Care).
     * Empty: the storefront writes them from the shop filters.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('product_details')->nullable()->after('occasion');
            $table->text('design_details')->nullable()->after('product_details');
            $table->text('material_care')->nullable()->after('design_details');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['product_details', 'design_details', 'material_care']);
        });
    }
};
