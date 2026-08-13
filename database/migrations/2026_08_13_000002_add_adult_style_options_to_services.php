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
            if (!Schema::hasColumn('services', 'has_length')) {
                $table->boolean('has_length')->default(true)->after('for_kids');
            }
            if (!Schema::hasColumn('services', 'has_tip_finish')) {
                $table->boolean('has_tip_finish')->default(false)->after('has_length');
            }
            if (!Schema::hasColumn('services', 'duration')) {
                $table->string('duration', 50)->nullable()->after('has_tip_finish');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('services')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            foreach (['has_length', 'has_tip_finish', 'duration'] as $col) {
                if (Schema::hasColumn('services', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
