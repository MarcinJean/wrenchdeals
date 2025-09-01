<?php

namespace App\Http\Controllers;

use App\Jobs\SendCouponEmail;
use App\Services\CouponCampaignService;
use App\Models\CouponCampaign;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\GenerateCouponRequest;

class CouponGenerationController extends Controller
{
    protected CouponCampaignService $service;

    public function __construct(CouponCampaignService $service)
    {
        $this->service = $service;
    }

    public function generate(GenerateCouponRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $request->user();
        $campaign = CouponCampaign::findOrFail($data['campaign_id']);
        $instance = $this->service->generateInstance($campaign, $data['contact'], $user);
        return response()->json($instance, 201);
    }

    public function email(EmailCouponRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Normalize code input
        $code = strtoupper(preg_replace('/[^A-Z0-9]/', '', $data['code']));
        $instance = CouponInstance::where('code', $code)->firstOrFail();

        $recipient = $data['email'] ?? $request->user()?->email;
        SendCouponEmail::dispatch($instance->code, $recipient);

        return response()->json(['message' => 'Coupon emailed'], 202);
    }

}
