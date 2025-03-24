<?php

namespace App\Policies;

use App\Models\SongYear;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SongYearPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('song_year_access');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SongYear $songYear): bool
    {
        return $user->hasPermission('song_year_show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('song_year_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SongYear $songYear): bool
    {
        return $user->hasPermission('song_year_edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SongYear $songYear): bool
    {
        return $user->hasPermission('song_year_delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SongYear $songYear): bool
    {
        return $user->hasPermission('song_year_edit');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SongYear $songYear): bool
    {
        return $user->hasPermission('song_year_delete');
    }
}
