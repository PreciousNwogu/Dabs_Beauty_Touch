<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('services') || Schema::hasColumn('services', 'has_eight_to_ten_rows')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            $after = Schema::hasColumn('services', 'has_row_options') ? 'has_row_options' : 'has_tip_finish';
            $table->boolean('has_eight_to_ten_rows')->default(false)->after($after);
        });

        $query = DB::table('services');
        if (Schema::hasColumn('services', 'has_row_options') && Schema::hasColumn('services', 'has_fifteen_plus_rows')) {
            $query->where(function ($q) {
                $q->where('has_row_options', true)->orWhere('has_fifteen_plus_rows', true);
            });
        } elseif (Schema::hasColumn('services', 'has_row_options')) {
            $query->where('has_row_options', true);
        }
        $query->update(['has_eight_to_ten_rows' => true]);
    }

    public function down(): void
    {
        if (!Schema::hasTable('services') || !Schema::hasColumn('services', 'has_eight_to_ten_rows')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('has_eight_to_ten_rows');
        });
    }
};
