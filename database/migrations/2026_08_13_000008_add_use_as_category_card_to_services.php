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
            if (!Schema::hasColumn('services', 'use_as_category_card')) {
                $table->boolean('use_as_category_card')->default(false)->after('image_url');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('services')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'use_as_category_card')) {
                $table->dropColumn('use_as_category_card');
            }
        });
    }
};
