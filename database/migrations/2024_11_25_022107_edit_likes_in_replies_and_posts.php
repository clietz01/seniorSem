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
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->integer('likes')->default(0)->change();
        });

        Schema::table('replies', function (Blueprint $table){

            $table->integer('likes')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('likes')->nullable(false)->change();
            $table->dropDefaultValue('likes');
        });

        // Revert the 'likes' column changes in the 'replies' table
        Schema::table('replies', function (Blueprint $table) {
            $table->integer('likes')->nullable(false)->change();
            $table->dropDefaultValue('likes');
        });
    }
};
