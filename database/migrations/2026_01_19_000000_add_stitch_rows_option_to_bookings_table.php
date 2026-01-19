<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'stitch_rows_option')) {
                // ten_or_less = 8–10 rows, more_than_ten = tiny stitch (>10 rows) +$20
                $table->string('stitch_rows_option')->nullable()->after('hair_mask_option');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'stitch_rows_option')) {
                $table->dropColumn('stitch_rows_option');
            }
        });
    }
};


