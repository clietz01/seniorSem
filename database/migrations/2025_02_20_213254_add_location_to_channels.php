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
        Schema::table('channels', function (Blueprint $table) {
            //
            $table->decimal('latitude', 10, 0)->nullable();
            $table->decimal('longitude', 11, 0)->nullable();
            $table->decimal('radius', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('channels', function (Blueprint $table) {
            //
        });
    }
};
