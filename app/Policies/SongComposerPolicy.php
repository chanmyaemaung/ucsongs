<?php

namespace App\Policies;

use App\Models\SongComposer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SongComposerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('song_composer_access');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SongComposer $songComposer): bool
    {
        return $user->hasPermission('song_composer_show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('song_composer_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SongComposer $songComposer): bool
    {
        return $user->hasPermission('song_composer_edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SongComposer $songComposer): bool
    {
        return $user->hasPermission('song_composer_delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SongComposer $songComposer): bool
    {
        return $user->hasPermission('song_composer_edit');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SongComposer $songComposer): bool
    {
        return $user->hasPermission('song_composer_delete');
    }
}
