<?php

namespace App\Policies;

use App\Models\CouponCampaign;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CouponCampaignPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        // only see campaigns for dealers you’re assigned to
        return $user->dealers()->exists();
    }

    public function view(User $user, CouponCampaign $campaign)
    {
        return $user->dealers->contains($campaign->dealer_id);
    }

    public function create(User $user) { /* any employee */ }

    public function update(User $user, CouponCampaign $c) {
        return $user->dealers->contains($c->dealer_id);
    }

    public function delete(User $user, CouponCampaign $c) {
        return $user->dealers->contains($c->dealer_id);
    }
}
