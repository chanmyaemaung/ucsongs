<?php

namespace App\Policies;

use App\Models\FamilyPledge;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FamilyPledgePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('family_pledge_access');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FamilyPledge $familyPledge): bool
    {
        return $user->hasPermission('family_pledge_show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('family_pledge_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FamilyPledge $familyPledge): bool
    {
        return $user->hasPermission('family_pledge_edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FamilyPledge $familyPledge): bool
    {
        return $user->hasPermission('family_pledge_delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FamilyPledge $familyPledge): bool
    {
        return $user->hasPermission('family_pledge_edit');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FamilyPledge $familyPledge): bool
    {
        return $user->hasPermission('family_pledge_delete');
    }
}
