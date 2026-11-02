<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Website content and what visitors send in: blog, careers, enquiries, newsletter, settings.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // blog-details.html?post=<slug>
            $table->string('title');
            $table->string('tag');
            $table->string('category'); // space-separated, for the blog filters
            $table->date('published_on');
            $table->string('read_time', 30);
            $table->string('image');
            $table->string('alt')->nullable();
            $table->text('excerpt');
            $table->string('shop_label')->nullable();
            $table->string('shop_href')->nullable();
            $table->json('body'); // blocks: {h} | {p} | {list} | {quote}
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('job_openings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // career-details.html?job=<slug>
            $table->string('title');
            $table->string('department');
            $table->string('location');
            $table->string('type', 40);
            $table->string('experience', 40);
            $table->text('summary');
            $table->json('responsibilities');
            $table->json('requirements');
            $table->json('offer')->nullable(); // null: the shared benefits list
            $table->boolean('is_open')->default(true);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_opening_id')->nullable()->constrained()->nullOnDelete();
            $table->string('position');
            $table->string('name');
            $table->string('email');
            $table->string('phone', 30);
            $table->text('message')->nullable();
            $table->string('cv_path');
            $table->string('cv_name');
            $table->string('status', 20)->default('new')->index(); // new | shortlisted | rejected | hired
            $table->timestamps();
        });

        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('type', 30)->default('bulk');
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('phone', 30);
            $table->string('order_type')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->string('budget')->nullable();
            $table->date('needed_by')->nullable();
            $table->text('message')->nullable();
            $table->string('status', 20)->default('new')->index(); // new | quoted | closed
            $table->timestamps();
        });

        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('source', 30)->nullable();
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('enquiries');
        Schema::dropIfExists('job_applications');
        Schema::dropIfExists('job_openings');
        Schema::dropIfExists('blogs');
    }
};
