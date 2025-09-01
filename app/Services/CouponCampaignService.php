<?php

namespace App\Services;

use App\Models\CouponCampaign;
use App\Models\CouponInstance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CouponCampaignService
{
    /**
     * Create a new coupon campaign with initial counters.
     *
     * @param  array  $data
     * @return CouponCampaign
     */
    public function createCampaign(array $data): CouponCampaign
    {
        return DB::transaction(function () use ($data) {
            $campaign = CouponCampaign::create([
                'dealer_id'        => $data['dealer_id'],
                'name'             => $data['name'],
                'start_at'         => $data['start_at'] ?? null,
                'expires_at'       => $data['expires_at'] ?? null,
                'generation_limit' => $data['generation_limit'] ?? null,
                'generation_count' => 0,
            ]);

            if (!empty($data['service_category_ids'])) {
                $campaign->serviceCategories()->sync($data['service_category_ids']);
            }

            if (!empty($data['vehicle_make_ids'])) {
                $campaign->vehicleMakes()->sync($data['vehicle_make_ids']);
            }

            return $campaign;
        });
    }

    /**
     * Determine if a new coupon instance can be generated for a campaign.
     */
    public function canGenerate(CouponCampaign $campaign): bool
    {
        // Use UTC now for comparison since expires_at is stored in UTC
        $nowUtc = Carbon::now('UTC');

        // Check date-based expiration
        if ($campaign->expires_at && $nowUtc->greaterThan($campaign->expires_at)) {
            return false;
        }

        // Check generation limit
        if ($campaign->generation_limit !== null && $campaign->generation_count >= $campaign->generation_limit) {
            return false;
        }

        return true;
    }

    /**
     * Generate a new coupon instance for a campaign.
     *
     * @param  CouponCampaign  $campaign
     * @param  string          $contact      Email or phone for guest
     * @param  User|null       $user         Authenticated user or null for guest
     * @return CouponInstance
     *
     * @throws \Exception if campaign limits reached
     */
    public function generateInstance(CouponCampaign $campaign, string $contact, ?User $user = null): CouponInstance
    {
        if (! $this->canGenerate($campaign)) {
            throw new \Exception('Campaign is no longer active or limit reached.');
        }

        // Atomically increment generation_count
        $updated = DB::table('coupon_campaigns')
            ->where('id', $campaign->id)
            ->where(function($q) {
                $q->whereNull('generation_limit')
                    ->orWhereColumn('generation_count', '<', 'generation_limit');
            })
            ->increment('generation_count');

        if (! $updated) {
            throw new \Exception('Failed to increment generation count.');
        }

        // Create instance
        return CouponInstance::create([
            'campaign_id'   => $campaign->id,
            'code'          => $this->makeCode(),
            'status'        => $user ? 'issued' : 'guest',
            'user_id'       => $user?->id,
            'guest_contact' => $user ? null : $contact,
        ]);
    }

    /**
     * Redeem a coupon instance by code.
     *
     * @param  string  $rawCode
     * @param  User    $staffUser
     * @param  string  $repairOrderId
     * @return CouponInstance
     *
     * @throws \Exception on invalid or already redeemed
     */
    public function redeemInstance(string $rawCode, User $staffUser, string $repairOrderId): CouponInstance
    {
        // Normalize input: strip non-alphanumeric, uppercase
        $code = strtoupper(preg_replace('/[^A-Z0-9]/', '', $rawCode));

        $instance = CouponInstance::where('code', $code)->firstOrFail();
        if ($instance->status === 'redeemed') {
            throw new \Exception('Coupon already redeemed.');
        }

        $instance->update([
            'status'          => 'redeemed',
            'redeemed_at'     => Carbon::now('UTC'),
            'staff_user_id'   => $staffUser->id,
            'repair_order_id' => $repairOrderId,
        ]);

        return $instance;
    }

    /**
     * Generate a secure random code (no dashes) for an instance.
     */
    protected function makeCode(int $length = 10): string
    {
        $bytes = random_bytes($length);
        // Base64 to characters safe for coupon codes
        $code = rtrim(strtr(base64_encode($bytes), '+/', 'AZ'), '=');
        return substr($code, 0, $length);
    }
}
