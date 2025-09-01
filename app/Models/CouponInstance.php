<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CouponInstance extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['status', 'redeemed_at'];
    public mixed $campaign;
    protected $fillable = ['campaign_id', 'code', 'status', 'user_id', 'guest_contact', 'redeemed_at', 'staff_user_id', 'repair_order_id'];
    protected $casts = ['redeemed_at' => 'datetime'];

    public function campaign(): belongsTo
    {
        return $this->belongsTo(CouponCampaign::class, 'campaign_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function staffUser(): belongsTo
    {
        return $this->belongsTo(User::class, 'staff_user_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        // TODO: Implement getActivitylogOptions() method.
    }

}
