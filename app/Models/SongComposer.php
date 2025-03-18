<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SongComposer extends Model
{
    protected $fillable = ['name', 'description', 'image'];

    // Relationship with Song
    public function songs(): HasMany
    {
        return $this->hasMany(Song::class, 'composer_id');
    }
}
