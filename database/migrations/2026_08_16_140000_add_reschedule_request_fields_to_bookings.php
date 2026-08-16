<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (! Schema::hasColumn('bookings', 'reschedule_requested_date')) {
                $table->date('reschedule_requested_date')->nullable()->after('notes');
            }
            if (! Schema::hasColumn('bookings', 'reschedule_requested_time')) {
                $table->string('reschedule_requested_time', 20)->nullable()->after('reschedule_requested_date');
            }
            if (! Schema::hasColumn('bookings', 'reschedule_request_note')) {
                $table->text('reschedule_request_note')->nullable()->after('reschedule_requested_time');
            }
            if (! Schema::hasColumn('bookings', 'reschedule_request_status')) {
                $table->string('reschedule_request_status', 20)->nullable()->after('reschedule_request_note');
            }
            if (! Schema::hasColumn('bookings', 'reschedule_requested_at')) {
                $table->timestamp('reschedule_requested_at')->nullable()->after('reschedule_request_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            foreach ([
                'reschedule_requested_date',
                'reschedule_requested_time',
                'reschedule_request_note',
                'reschedule_request_status',
                'reschedule_requested_at',
            ] as $column) {
                if (Schema::hasColumn('bookings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
