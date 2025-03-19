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
        Schema::create('family_pledges', function (Blueprint $table) {
            $table->id();
            $table->string('language_code'); // e.g. 'en', 'my', 'ko'
            $table->string('language_name'); // e.g. 'English', 'Burmese', 'Korean'
            $table->string('title');
            $table->longText('content'); // Rich text content for the entire pledge
            $table->json('pledge_items')->nullable(); // Store individual pledge items as JSON for structured access
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            
            // Add unique constraint to prevent duplicate language entries
            $table->unique('language_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_pledges');
    }
}; 