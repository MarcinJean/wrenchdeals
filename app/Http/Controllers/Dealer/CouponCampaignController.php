<?php

namespace App\Http\Controllers\Dealer;

use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponCampaignRequest;
use App\Http\Requests\UpdateCouponCampaignRequest;
use App\Models\CouponCampaign;
use App\Models\ServiceCategory;
use App\Models\VehicleMake;
use App\Models\Dealer;
use App\Services\CouponCampaignService;
use Inertia\Inertia;

class CouponCampaignController extends Controller
{
    public function __construct()
    {
       // $this->authorizeResource(CouponCampaign::class, 'campaign');
    }

    public function index()
    {
        DB::enableQueryLog();
        $dealerIds = auth()->user()->dealers()->pluck('id');


        $campaigns = CouponCampaign::query()
            ->whereIn('dealer_id', $dealerIds)
            ->withCount('instances')
            ->paginate(15)
            ->through(fn($c) => [
                'id'                => $c->id,
                'name'              => $c->name,
                'expires_at'        => $c->expires_at,
                'generation_limit'  => $c->generation_limit,
                'generation_count'  => $c->generation_count,
            ]);

        return Inertia::render('Dealer/Campaigns/Index', [
            'campaigns' => $campaigns,
        ]);
    }

    public function create()
    {
        return Inertia::render('Dealer/Campaigns/Create', [
            'serviceCategories' => ServiceCategory::select('id','name')->get(),
            'vehicleMakes'      => VehicleMake::select('id','name')->get(),
            'dealers'           => auth()->user()->dealers()->select('id','name')->get(),
        ]);
    }

    public function store(StoreCouponCampaignRequest $request, CouponCampaignService $svc)
    {
        $data = $request->validated();
        // if your user can belong to multiple dealers, you might loop; here we just pick the first
        $data['dealer_id'] = $data['dealers'][0] ?? auth()->user()->dealers()->first()->id;
        $svc->createCampaign($data);
        return redirect()->route('dealer.campaigns.index')
            ->with('success','Campaign created.');
    }

    public function edit(CouponCampaign $campaign)
    {
        return Inertia::render('Dealer/Campaigns/Edit', [
            'campaign' => $campaign->load(['serviceCategories','vehicleMakes','dealers']),
            'serviceCategories' => ServiceCategory::select('id','name')->get(),
            'vehicleMakes'      => VehicleMake::select('id','name')->get(),
            'dealers'           => auth()->user()->dealers->map(fn($d)=>['id'=>$d->id,'name'=>$d->name]),
        ]);
    }

    public function update(UpdateCouponCampaignRequest $request, CouponCampaign $campaign, CouponCampaignService $svc)
    {
        $svc->updateCampaign($campaign, $request->validated());
        return redirect()->route('dealer.campaigns.index');
    }

    public function destroy(CouponCampaign $campaign, CouponCampaignService $svc)
    {
        $svc->deleteCampaign($campaign);
        return redirect()->route('dealer.campaigns.index');
    }
}
