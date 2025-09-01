<?php

namespace App\Http\Controllers;

use App\Services\CouponCampaignService;
use App\Models\CouponCampaign;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreCouponCampaignRequest;

class CouponCampaignController extends Controller
{
    protected CouponCampaignService $service;

    public function __construct(CouponCampaignService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $dealerId = $request->user()->dealers()->first()->id;
        $campaigns = CouponCampaign::where('dealer_id', $dealerId)->get();
        return response()->json($campaigns);
    }

    public function store(StoreCouponCampaignRequest $request): JsonResponse
    {
        $campaign = $this->service->createCampaign($request->validated());
        return response()->json($campaign, 201);
    }

    public function show(CouponCampaign $campaign): JsonResponse
    {
        return response()->json($campaign->load(['serviceCategories', 'vehicleMakes']));
    }
}
