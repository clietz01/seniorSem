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
        //
        Schema::table('channels', function (Blueprint $table)
        {

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //adding it back just in case

        Schema::table('channels', function (Blueprint $table) {
            // Recreate the user_id column
            $table->unsignedBigInteger('user_id');
            // Recreate the foreign key constraint
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
