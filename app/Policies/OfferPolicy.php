<?php

namespace App\Policies;

use App\Models\Offer;

class OfferPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->can('offer-index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Offer $offer): bool
    {
        return $user->can('offer-show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->can('offer-create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Offer $offer): bool
    {
        return $user->can('offer-update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Offer $offer): bool
    {
        return $user->can('offer-delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Offer $offer): bool
    {
        return $user->can('offer-restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Offer $offer): bool
    {
        return $user->can('offer-forceDelete');
    }
}
