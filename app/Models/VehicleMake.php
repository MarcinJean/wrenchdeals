<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleMake extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function models()
    {
        return $this->hasMany(VehicleModel::class, 'make_id');
    }

    public function dealers()
    {
        return $this->belongsToMany(Dealer::class, 'dealer_vehicle_make');
    }

    public function campaigns()
    {
        return $this->belongsToMany(CouponCampaign::class, 'coupon_campaign_vehicle_make');
    }
}
