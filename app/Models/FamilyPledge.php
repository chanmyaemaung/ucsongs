<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyPledge extends Model
{
    protected $fillable = [
        'language_code',
        'language_name',
        'title',
        'content',
        'pledge_items',
        'is_active',
        'display_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pledge_items' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Set the pledge items as JSON.
     *
     * @param array $value
     * @return void
     */
    public function setPledgeItemsAttribute($value)
    {
        $this->attributes['pledge_items'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Get the pledge items and decode from JSON.
     *
     * @param string|null $value
     * @return array
     */
    public function getPledgeItemsAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }

        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            return [];
        }

        return $decoded;
    }
}
