<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dealer extends Model
{
    use SoftDeletes;

    protected $fillable = ['dealer_group_id', 'name', 'address', 'timezone', 'status'];

    public function group()
    {
        return $this->belongsTo(DealerGroup::class, 'dealer_group_id');
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'dealer_user')
            ->withPivot('title')
            ->withTimestamps();
    }

    public function campaigns()
    {
        return $this->belongsToMany(CouponCampaign::class, 'coupon_dealer');
    }

    public function vehicleMakes()
    {
        return $this->belongsToMany(VehicleMake::class, 'dealer_vehicle_make');
    }
}
