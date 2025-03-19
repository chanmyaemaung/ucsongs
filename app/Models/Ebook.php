<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Ebook extends Model
{
    protected $fillable = [
        'title',
        'book_file',
        'book_type',
        'author',
        'publication_date',
        'is_active'
    ];

    protected static function boot()
    {
        parent::boot();

        // When an existing model is being updated
        static::updating(function ($ebook) {
            // Ensure we're working with the database instance
            $originalEbook = self::find($ebook->id);

            if ($originalEbook && !empty($originalEbook->book_file)) {
                $oldFile = $originalEbook->book_file;
                $newFile = $ebook->book_file;

                // If the file has changed, delete the old file
                if ($oldFile !== $newFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                    Log::info("Deleted old ebook file from storage: {$oldFile}");
                }
            }
        });

        // When a model is being deleted
        static::deleting(function ($ebook) {
            // Delete the ebook file from storage
            if (!empty($ebook->book_file) && Storage::disk('public')->exists($ebook->book_file)) {
                Storage::disk('public')->delete($ebook->book_file);
                Log::info("Deleted ebook file during deletion: {$ebook->book_file}");
            }
        });
    }
}
