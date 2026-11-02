<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Blog posts' Shop links to the clean page URLs (bridal.html → bridal, index.html → ./).
     */
    public function up(): void
    {
        DB::table('blogs')->where('shop_href', 'like', '%.html%')->get(['id', 'shop_href'])->each(function ($blog) {
            $href = preg_replace(['/^index\.html/', '/^([a-z0-9-]+)\.html/'], ['./', '$1'], $blog->shop_href);
            DB::table('blogs')->where('id', $blog->id)->update(['shop_href' => $href]);
        });
    }

    public function down(): void
    {
        // The old .html addresses still redirect, so there's nothing to undo.
    }
};
