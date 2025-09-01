<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasRoles, SoftDeletes, HasApiTokens;

    public mixed $dealers;
    protected $fillable = ['name', 'email', 'password', 'phone'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['phone' => 'encrypted'];

    public function dealers(): belongsToMany
    {
        return $this->belongsToMany(Dealer::class, 'dealer_user');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function instances()
    {
        return $this->hasMany(CouponInstance::class);
    }
}
