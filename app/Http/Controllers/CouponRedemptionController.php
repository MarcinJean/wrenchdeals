<?php

namespace App\Http\Controllers;

use App\Services\CouponCampaignService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RedeemCouponRequest;

class CouponRedemptionController extends Controller
{
    protected CouponCampaignService $service;

    public function __construct(CouponCampaignService $service)
    {
        $this->service = $service;
    }

    public function redeem(RedeemCouponRequest $request): JsonResponse
    {
        $data = $request->validated();
        $staffUser = $request->user();
        $instance = $this->service->redeemInstance(
            $data['code'],
            $staffUser,
            $data['repair_order_id']
        );
        return response()->json($instance);
    }
}
