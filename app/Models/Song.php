<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Song extends Model
{
    // Mass assignable attributes
    protected $fillable = [
        'title',
        'author_id',
        'composer_id',
        'year_id',
        'content',
        'audio_files',
    ];

    // Cast the audio_files column as an array (because it's stored as JSON in the database)
    protected $casts = [
        'audio_files' => 'array',
    ];

    // Delete related files when the model is deleted or updated
    protected static function boot()
    {
        parent::boot();

        // When an existing model is being updated
        static::updating(function ($song) {
            // Ensure we're working with the database instance
            $originalSong = self::find($song->id);

            if ($originalSong && ! empty($originalSong->audio_files)) {
                $oldFiles = is_array($originalSong->audio_files) ? $originalSong->audio_files : [];
                $newFiles = is_array($song->audio_files) ? $song->audio_files : [];

                // Find files that were removed
                $removedFiles = array_diff($oldFiles, $newFiles);

                // Delete removed files from storage
                foreach ($removedFiles as $file) {
                    if (Storage::disk('public')->exists($file)) {
                        Storage::disk('public')->delete($file);
                        Log::info("Deleted file from storage: {$file}");
                    }
                }
            }
        });

        // When a model is being deleted
        static::deleting(function ($song) {
            // Delete all audio files from storage
            if (! empty($song->audio_files)) {
                foreach ((array) $song->audio_files as $file) {
                    if (Storage::disk('public')->exists($file)) {
                        Storage::disk('public')->delete($file);
                        Log::info("Deleted file during song deletion: {$file}");
                    }
                }
            }
        });
    }

    // Relationship with SongAuthor
    public function author(): BelongsTo
    {
        return $this->belongsTo(SongAuthor::class);
    }

    // Relationship with SongComposer
    public function composer(): BelongsTo
    {
        return $this->belongsTo(SongComposer::class);
    }

    // Relationship with SongYear
    public function year(): BelongsTo
    {
        return $this->belongsTo(SongYear::class)->withDefault(['year' => 'N/A']);
    }

    public function setAudioFilesAttribute($value)
    {
        // Log when audio_files attribute is changed
        Log::info('Setting audio_files attribute', [
            'song_id' => $this->id ?? 'new_song',
            'old_value' => $this->attributes['audio_files'] ?? null,
            'new_value' => $value,
        ]);

        $this->attributes['audio_files'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getAudioFilesAttribute($value)
    {
        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::warning('JSON decode error for audio_files', [
                'song_id' => $this->id,
                'error' => json_last_error_msg(),
                'value' => $value,
            ]);

            return [];
        }

        return $decoded;
    }
}
