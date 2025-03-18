<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SongAuthor extends Model
{
    protected $fillable = ['name', 'description', 'image'];

    // Relationship with Song
    public function songs(): HasMany
    {
        return $this->hasMany(Song::class, 'author_id');
    }
}
