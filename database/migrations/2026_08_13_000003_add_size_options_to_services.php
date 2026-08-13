<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('services') || Schema::hasColumn('services', 'size_options')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            $table->json('size_options')->nullable()->after('duration');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('services') || !Schema::hasColumn('services', 'size_options')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('size_options');
        });
    }
};
