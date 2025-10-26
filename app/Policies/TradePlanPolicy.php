<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\TradePlan;
use App\Models\User;

class TradePlanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Users can view their own trade plans
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TradePlan $tradePlan): bool
    {
        return $user->id === $tradePlan->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create trade plans
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TradePlan $tradePlan): bool
    {
        return $user->id === $tradePlan->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TradePlan $tradePlan): bool
    {
        return $user->id === $tradePlan->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TradePlan $tradePlan): bool
    {
        return $user->id === $tradePlan->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TradePlan $tradePlan): bool
    {
        return $user->id === $tradePlan->user_id;
    }
}
