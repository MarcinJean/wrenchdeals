<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\CouponInstance;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * List active (unredeemed) coupons for a given dealer.
     *
     * GET /api/{version}/coupons?dealer={dealer}
     */
    public function index(Request $request): JsonResponse
    {
        $dealerId = $request->query('dealer');
        if (! $dealerId) {
            return response()->json(['message' => 'dealer ID is required'], 400);
        }

        $nowUtc = Carbon::now('UTC');

        $instances = CouponInstance::with('campaign')
            ->whereHas('campaign', function($q) use ($dealerId, $nowUtc) {
        $q->where('dealer_id', $dealerId)
            ->where(function($q2) use ($nowUtc) {
                $q2->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', $nowUtc);
            })
            ->where(function($q3) {
                $q3->whereNull('generation_limit')
                    ->orWhereColumn('generation_count', '<', 'generation_limit');
            });
    })
        ->where('status', '!=', 'redeemed')
        ->get();

        return response()->json($instances);
    }
}
