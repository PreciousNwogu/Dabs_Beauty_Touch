<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('custom_service_requests', 'converted_booking_id')) {
            Schema::table('custom_service_requests', function (Blueprint $table) {
                $table->unsignedBigInteger('converted_booking_id')->nullable()->after('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('custom_service_requests', 'converted_booking_id')) {
            Schema::table('custom_service_requests', function (Blueprint $table) {
                $table->dropColumn('converted_booking_id');
            });
        }
    }
};
