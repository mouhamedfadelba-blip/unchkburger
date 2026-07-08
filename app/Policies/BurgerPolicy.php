<?php

namespace App\Policies;

use App\Models\Burger;
use App\Models\User;

class BurgerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool { return true; }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Burger $burger): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool { return $user->hasRole('manager'); }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Burger $burger): bool { return $user->hasRole('manager'); }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Burger $burger): bool { return $user->hasRole('manager'); }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Burger $burger): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Burger $burger): bool
    {
        return false;
    }
}