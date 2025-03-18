<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SongYear extends Model
{
    protected $fillable = ['year', 'description', 'image'];

    // Relationship with Song
    public function songs(): HasMany
    {
        return $this->hasMany(Song::class, 'year_id');
    }
}
