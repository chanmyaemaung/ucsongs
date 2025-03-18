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
        Schema::table('songs', function (Blueprint $table) {
            // Drop the existing foreign key first
            $table->dropForeign(['year_id']);

            // Change the column to be nullable
            $table->foreignId('year_id')->nullable()->change();

            // Re-add the foreign key constraint
            $table->foreign('year_id')->references('id')->on('song_years');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            // Drop the existing foreign key
            $table->dropForeign(['year_id']);

            // Change back to non-nullable
            $table->foreignId('year_id')->nullable(false)->change();

            // Re-add the foreign key constraint
            $table->foreign('year_id')->references('id')->on('song_years');
        });
    }
};
