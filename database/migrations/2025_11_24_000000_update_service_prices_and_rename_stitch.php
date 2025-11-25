<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update base prices to the requested authoritative values
        DB::table('services')->where('slug', 'small-knotless')->update(['base_price' => 170.00]);
        DB::table('services')->where('slug', 'smedium-knotless')->update(['base_price' => 150.00]);
        DB::table('services')->where('slug', 'medium-knotless')->update(['base_price' => 130.00]);
        DB::table('services')->where('slug', 'jumbo-knotless')->update(['base_price' => 100.00]);

        // Rename stitch braids display name where present
        DB::table('services')->where('slug', 'stitch-braids')->update(['name' => '8 Rows Stitch Braids']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to previous values (seed defaults)
        DB::table('services')->where('slug', 'small-knotless')->update(['base_price' => 150.00]);
        DB::table('services')->where('slug', 'smedium-knotless')->update(['base_price' => 130.00]);
        DB::table('services')->where('slug', 'medium-knotless')->update(['base_price' => 130.00]);
        DB::table('services')->where('slug', 'jumbo-knotless')->update(['base_price' => 80.00]);

        DB::table('services')->where('slug', 'stitch-braids')->update(['name' => 'Stitch Braids']);
    }
};
