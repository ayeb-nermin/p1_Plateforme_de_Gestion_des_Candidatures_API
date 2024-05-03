<?php

namespace App\Policies;

use App\Models\Cv;

class CvPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->can('cv-index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Cv $cv): bool
    {
        return $user->can('cv-show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->can('cv-create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Cv $cv): bool
    {
        return $user->can('cv-update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Cv $cv): bool
    {
        return $user->can('cv-delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Cv $cv): bool
    {
        return $user->can('cv-restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Cv $cv): bool
    {
        return $user->can('cv-forceDelete');
    }
}
