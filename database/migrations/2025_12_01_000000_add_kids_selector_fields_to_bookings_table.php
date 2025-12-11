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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('kb_braid_type')->nullable()->after('service');
            $table->string('kb_finish')->nullable()->after('kb_braid_type');
            $table->string('kb_length')->nullable()->after('kb_finish');
            $table->text('kb_extras')->nullable()->after('kb_length');

            // Keep selector-specific price breakdown separate from main price columns
            $table->decimal('kb_base_price', 8, 2)->nullable()->after('final_price');
            $table->decimal('kb_length_adjustment', 8, 2)->nullable()->after('kb_base_price');
            $table->decimal('kb_final_price', 8, 2)->nullable()->after('kb_length_adjustment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'kb_braid_type', 'kb_finish', 'kb_length', 'kb_extras',
                'kb_base_price', 'kb_length_adjustment', 'kb_final_price'
            ]);
        });
    }
};
