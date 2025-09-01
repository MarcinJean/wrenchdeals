<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CouponCampaignController;
use App\Http\Controllers\CouponGenerationController;
use App\Http\Controllers\CouponRedemptionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CouponController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group. Version your API for graceful evolution.
|
*/

Route::prefix('v1')
    ->as('api.v1.')
    ->group(function () {
        // Public endpoints
        Route::post('register', [RegisteredUserController::class, 'store'])
            ->middleware('guest')
            ->name('auth.register');

        Route::post('login', [AuthenticatedSessionController::class, 'store'])
            ->middleware('guest')
            ->name('auth.login');

        Route::get('coupons', [CouponController::class, 'index'])
            ->name('coupons.index');

        Route::post('coupons/generate', [CouponGenerationController::class, 'generate'])
            ->name('coupons.generate');

        Route::post('coupons/email', [CouponGenerationController::class, 'email'])
            ->name('coupons.email');

        // Protected endpoints: require authentication via Sanctum
        Route::middleware('auth:sanctum')->group(function () {
            // Auth
            Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
            Route::get('user', [AuthController::class, 'user'])->name('auth.user');

            // Coupon campaign management
            Route::get('campaigns', [CouponCampaignController::class, 'index'])
                ->name('campaigns.index');
            Route::post('campaigns', [CouponCampaignController::class, 'store'])
                ->name('campaigns.store');
            Route::get('campaigns/{campaign}', [CouponCampaignController::class, 'show'])
                ->name('campaigns.show');

            // Redeem a coupon
            Route::post('coupons/redeem', [CouponRedemptionController::class, 'redeem'])
                ->name('coupons.redeem');

            // Vehicle management
            Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
            Route::post('vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
            Route::delete('vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
        });
    });
