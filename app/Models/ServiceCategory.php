<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'description'];

    public function campaigns()
    {
        return $this->belongsToMany(CouponCampaign::class, 'coupon_campaign_service_category');
    }
}
