<?php

namespace App\Policies;

use App\Models\SongAuthor;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SongAuthorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('song_author_access');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SongAuthor $songAuthor): bool
    {
        return $user->hasPermission('song_author_show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('song_author_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SongAuthor $songAuthor): bool
    {
        return $user->hasPermission('song_author_edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SongAuthor $songAuthor): bool
    {
        return $user->hasPermission('song_author_delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SongAuthor $songAuthor): bool
    {
        return $user->hasPermission('song_author_edit');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SongAuthor $songAuthor): bool
    {
        return $user->hasPermission('song_author_delete');
    }
}
