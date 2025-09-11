<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('bookings', 'confirmation_code')) {
            Schema::table('bookings', function (Blueprint $table) {
                // Add confirmation_code as nullable string after final_price (if present)
                $table->string('confirmation_code')->nullable()->after('final_price');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('bookings', 'confirmation_code')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('confirmation_code');
            });
        }
    }
};
