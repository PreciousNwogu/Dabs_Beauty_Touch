<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Keep the slug the same; just update the display name
        DB::table('services')
            ->where('slug', 'stitch-braids')
            ->update(['name' => '8–10 Rows Stitch Braids']);
    }

    public function down(): void
    {
        DB::table('services')
            ->where('slug', 'stitch-braids')
            ->update(['name' => '8 Rows Stitch Braids']);
    }
};


