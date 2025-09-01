<?php

namespace App\Policies;

use App\Models\CouponInstance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CouponInstancePolicy
{

    public function redeem(User $user, CouponInstance $instance): bool
    {
        // Allow only if the instance’s campaign.dealer_id is one of the user’s dealer IDs
      //  return $user->dealers->pluck('id')->contains($instance->campaign->dealer_id);
        return true;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CouponInstance $couponInstance): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CouponInstance $instance)
    {
       // return $user->dealers->contains($instance->campaign->dealer_id);
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CouponInstance $couponInstance): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CouponInstance $couponInstance): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CouponInstance $couponInstance): bool
    {
        return false;
    }
}
