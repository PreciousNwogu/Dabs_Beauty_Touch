<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('services')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'eight_to_ten_rows_price')) {
                $table->decimal('eight_to_ten_rows_price', 8, 2)->default(0)->after('has_fifteen_plus_rows');
            }
            if (!Schema::hasColumn('services', 'ten_plus_rows_price')) {
                $table->decimal('ten_plus_rows_price', 8, 2)->default(30)->after('eight_to_ten_rows_price');
            }
            if (!Schema::hasColumn('services', 'fifteen_plus_rows_price')) {
                $table->decimal('fifteen_plus_rows_price', 8, 2)->default(30)->after('ten_plus_rows_price');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('services')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            foreach (['eight_to_ten_rows_price', 'ten_plus_rows_price', 'fifteen_plus_rows_price'] as $col) {
                if (Schema::hasColumn('services', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
