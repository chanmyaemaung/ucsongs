<?php

namespace App\Policies;

use App\Models\Ebook;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EbookPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('ebook_access');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ebook $ebook): bool
    {
        return $user->hasPermission('ebook_show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('ebook_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ebook $ebook): bool
    {
        return $user->hasPermission('ebook_edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ebook $ebook): bool
    {
        return $user->hasPermission('ebook_delete');
    }
}
