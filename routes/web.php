<?php

use App\Http\Controllers\Dealer\CouponCampaignController;
use App\Http\Controllers\Dealer\CouponInstanceController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])
    ->prefix('dealer')
    ->name('dealer.')
    ->group(function () {
        // Show the form to enter a code and repair order
        Route::get('coupons/redeem', [CouponInstanceController::class, 'showRedeemForm'])
            ->name('coupons.redeem.form');
        // Process the redemption
        Route::post('coupons/redeem', [CouponInstanceController::class, 'redeem'])
            ->name('coupons.redeem');
        Route::post('coupons/validate', [CouponInstanceController::class, 'validate'])
            ->name('coupons.validate');
    });


Route::get('coupon/{coupon}', function (string $coupon) {

    $multipleCoupons = [
        0 => [
            'couponId'      => '123',
            'template'      => $coupon,
            'title'         => 'Brake Inspection',
            'image'         => 'https://storage.googleapis.com/phalanx-media-library/brake-3_560x350_2022.10.04_21.34.55.jpg',
            'description'   => 'Our experts will measure front and rear brake pad/shoe wear, measure rotor/drum wear, perform a brake fluid test, and provide manufacturer’s specifications. ',
            'discount'      => 'FREE',
            'expiry'        => '6/30/2025',
            'badgeText'     => 'Brakes',
            'color'         => '00287A',
            'disclaimer'    => 'Brake service costs extra. Participating authorized retailers only. Most vehicles. No cash value. Void where prohibited. Not valid on prior purchase or rain checks. Shop supply fee of 8%-10% of labor costs (up to $35) added to invoices over $35, includes cost and profit, and is not charged if prohibited. Other restrictions, fees, and taxes may apply. See store for details. © 2025 Bridgestone Retail Operations, LLC. All rights reserved.',

        ],
        1 => [
            'couponId'      => '456',
            'template'      => $coupon,
            'type'          => 'manufacturer',
            'specialLink'   => 'https://fordtireherocode.com/',
            'title'         => 'Military and First Responders',
            'image'         => 'https://cws.dealerconnection.com/images/xlarge_Tires.png',
            'description'   => 'Do you want to save big on your next vehicle or parts purchase? Now is your chance because here at Cloninger Ford of Hickory, we have a great deal for you. Take advantage of our customer vehicle pickup and delivery service, and you will receive a $50 coupon toward vehicle service or parts purchases. Visit us today for more details.',
            'discount'      => 'Receive an $80 instant discount with the purchase and installation of four select tires.',
            'expiry'        => '12/31/2025',
            'badgeText'     => 'Wheels & Tires',
            'color'         => '00287A',
            'disclaimer'    => 'The Ford Military and First Responder Tire Discount Program is available to active and retired Military and First Responders who purchase and have installed a set of four (4) qualifying tires. Qualifying customers are eligible to receive a discount of $80 off participating brands at the time of installation. Participating brands are: Goodyear®, Michelin, BFGoodrich®, Continental, General, Pirelli, Hankook, Bridgestone, Falken, and Toyo®. Toyo medium/commercial truck and Motorsport patterns are excluded. This discount is in addition to any other eligible discount, rebate, or offer a dealer or tire manufacturer may already provide. Tires must be installed at a participating U.S. Ford Dealer, Lincoln Retailer, or Quick Lane® store. Prior authorization is necessary before work is performed, and program-provided Hero Code must be presented at the time of purchase - ID.me account and validation are required. Hero Code is nontransferable and can only be used by the associated ID.me account holder. Additional details can be found here: Military and First Responders Tire Discount. Maximum of two Hero Codes per calendar year per customer can be generated/claimed. Offer valid for tires purchased and installed 1/1/25 - 12/31/25. Unused Hero Codes expire after 12/31/25. Quick Lane® is a registered trademark of Ford Motor Company.',
        ],
    ];

    return Inertia::render('Dealer/Coupons/Example', [
        'template' => $coupon,
        'specials' => $multipleCoupons
    ]);
})->middleware(['auth', 'verified'])->name('coupon.example');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::prefix('dealer')
    ->name('dealer.')
    ->group(function () {
        // Campaign CRUD
        Route::get('campaigns', [CouponCampaignController::class, 'index'])
            ->name('campaigns.index');
        Route::get('campaigns/create', [CouponCampaignController::class, 'create'])
            ->name('campaigns.create');
        Route::post('campaigns', [CouponCampaignController::class, 'store'])
            ->name('campaigns.store');
        Route::get('campaigns/{campaign}/edit', [CouponCampaignController::class, 'edit'])
            ->name('campaigns.edit');
        Route::put('campaigns/{campaign}', [CouponCampaignController::class, 'update'])
            ->name('campaigns.update');
        Route::delete('campaigns/{campaign}', [CouponCampaignController::class, 'destroy'])
            ->name('campaigns.destroy');

        // Coupon listing & redemption
        Route::get('coupons', [CouponInstanceController::class, 'index'])
            ->name('coupons.index');
    });
