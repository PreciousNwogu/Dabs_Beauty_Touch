<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('services') || Schema::hasColumn('services', 'has_row_options')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            $table->boolean('has_row_options')->default(false)->after('has_tip_finish');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('services') || !Schema::hasColumn('services', 'has_row_options')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('has_row_options');
        });
    }
};
