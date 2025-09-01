<?php

namespace App\Providers;

use App\Models\CouponCampaign;
use App\Models\CouponInstance;
use App\Models\Vehicle;
use App\Observers\VehicleObserver;
use App\Policies\CouponCampaignPolicy;
use App\Policies\CouponInstancePolicy;
use App\Policies\VehiclePolicy;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
        Vehicle::class => VehiclePolicy::class,
        CouponCampaign::class => CouponCampaignPolicy::class,
        //CouponInstance::class => CouponInstancePolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vehicle::observe(VehicleObserver::class);
        Inertia::share('flash', function () {
            return [
                'success' => session('success'),
                'error'   => session('error'),
            ];
        });
    }
}
