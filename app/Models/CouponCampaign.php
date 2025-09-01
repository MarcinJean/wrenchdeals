<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CouponCampaign extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['generation_count'];
    protected $fillable = ['dealer_id', 'name', 'start_at', 'expires_at', 'generation_limit', 'generation_count', 'image', 'description', 'disclaimer', 'color', 'template'];
    protected $casts = ['start_at' => 'datetime', 'expires_at' => 'datetime'];

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function serviceCategories(): belongsToMany
    {
        return $this->belongsToMany(ServiceCategory::class, 'coupon_campaign_service_category');
    }

    public function vehicleMakes(): belongsToMany
    {
        return $this->belongsToMany(VehicleMake::class, 'coupon_campaign_vehicle_make');
    }

    public function coupons(): hasMany
    {
        return $this->hasMany(CouponInstance::class, 'campaign_id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        // TODO: Implement getActivitylogOptions() method.
    }
}
