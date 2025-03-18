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
        // Add unique constraint to song_authors table
        Schema::table('song_authors', function (Blueprint $table) {
            $table->unique('name');
        });

        // Add unique constraint to song_composers table
        Schema::table('song_composers', function (Blueprint $table) {
            $table->unique('name');
        });

        // Add unique constraint to song_years table
        Schema::table('song_years', function (Blueprint $table) {
            $table->unique('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove unique constraint from song_authors table
        Schema::table('song_authors', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });

        // Remove unique constraint from song_composers table
        Schema::table('song_composers', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });

        // Remove unique constraint from song_years table
        Schema::table('song_years', function (Blueprint $table) {
            $table->dropUnique(['year']);
        });
    }
};
