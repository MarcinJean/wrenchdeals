<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\CouponInstance;
use App\Services\CouponCampaignService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Http\Requests\RedeemCouponRequest;

class CouponInstanceController extends Controller
{
    public function index()
    {
        $dealerIds = auth()->user()->dealers->pluck('id');
        $instances = CouponInstance::whereHas('campaign', fn($q) =>
        $q->whereIn('dealer_id', $dealerIds))
            ->with(['campaign','staffUser'])
            ->paginate(25);

        return Inertia::render('Dealer/Coupons/Index', [
            'instances' => $instances,
        ]);
    }

    public function showRedeemForm()
    {
        return Inertia::render('Dealer/Coupons/Redeem', [
            // you can pass any data if needed (e.g. open campaigns count)
        ]);
    }

    public function redeem(RedeemCouponRequest $request, CouponCampaignService $svc)
    {
        // Normalize and attempt redemption
        $code  = Str::upper(preg_replace('/[^A-Z0-9]/', '', $request->input('code')));
        $order = $request->input('repair_order_id');
        $staff = auth()->user();

        try {
            $instance = $svc->redeemInstance($code, $staff, $order);
            return redirect()
                ->route('dealer.coupons.redeem.form')
                ->with('success', "✅ Coupon {$instance->code} redeemed!");
        } catch (\Exception $e) {
            return redirect()
                ->route('dealer.coupons.redeem.form')
                ->with('error', $e->getMessage());
        }
    }

    public function validate(Request $request)
    {
        $response = ['error' => false];
        $couponCode = $request->input('coupon');
        $couponCodeFormatted = preg_replace('/^(\d{3})(\d{5})(\d{2})$/', '$1-$2-$3', $couponCode);

        $coupon = CouponInstance::where('code', $couponCode)->first();
        if(empty($coupon)){
            $response = [
                'error' => true,
                'message' => "Coupon Code {$couponCodeFormatted} not found!"
            ];
            return response()->json($response);
        }

      //  try {
           $campaign = DB::table('coupon_campaigns')->where('id', $coupon->campaign_id)->firstOrFail();
      //  } catch (\Exception $e) {
       //     $response['error'] = $e->getMessage();
      //  }
        $response['campaign'] = $campaign;
        return response()->json($response);
    }

    private function jsonDisplay($json){

        return response()->json($json);
    }
}
