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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('song_authors'); // Author of the song
            $table->foreignId('composer_id')->constrained('song_composers'); // Composer of the song
            $table->foreignId('year_id')->constrained('song_years'); // Year of the song
            $table->string('title');                    // Song title (e.g., "Blessing of Glory")
            $table->text('content');                   // Full song content in rich text (HTML format)
            $table->json('audio_files');               // Store multiple audio formats (e.g., MIDI, WAVE, MP3)
            $table->timestamps();                      // created_at, updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
