<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->decimal('discount_price', 8, 2)->nullable()->after('base_price');
            $table->string('category', 100)->nullable()->after('description');
            $table->boolean('is_active')->default(true)->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['discount_price', 'category', 'is_active']);
        });
    }
};
