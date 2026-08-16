<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('stored_images')) {
            Schema::create('stored_images', function (Blueprint $table) {
                $table->id();
                $table->string('public_path', 500)->unique();
                $table->string('mime', 100)->nullable();
                $table->longText('contents');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('stored_images');
    }
};
