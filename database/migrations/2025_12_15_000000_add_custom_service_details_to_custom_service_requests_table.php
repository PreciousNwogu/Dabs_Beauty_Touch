<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('custom_service_requests', function (Blueprint $table) {
            $table->string('service_category')->nullable()->after('service');
            $table->string('braid_size')->nullable()->after('service_category');
            $table->string('hair_length')->nullable()->after('braid_size');
            $table->string('budget_range')->nullable()->after('hair_length');
            $table->string('urgency')->nullable()->after('budget_range');
            $table->text('style_preferences')->nullable()->after('urgency');
            $table->text('special_requirements')->nullable()->after('style_preferences');
            $table->string('reference_image')->nullable()->after('special_requirements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_service_requests', function (Blueprint $table) {
            $table->dropColumn([
                'service_category',
                'braid_size',
                'hair_length',
                'budget_range',
                'urgency',
                'style_preferences',
                'special_requirements',
                'reference_image'
            ]);
        });
    }
};

