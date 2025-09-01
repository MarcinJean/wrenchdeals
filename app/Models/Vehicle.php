<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MarcinJean\LaravelVPic\Models\Vehicle as VpicVehicle;

class Vehicle extends Model
{
    protected $fillable = ['user_id', 'vin', 'make_id', 'model_id', 'year', 'raw_decode'];
    protected $casts = ['vin' => 'encrypted', 'raw_decode' => 'encrypted:json'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function make()
    {
        return $this->belongsTo(VehicleMake::class, 'make_id');
    }

    public function model()
    {
        return $this->belongsTo(VehicleModel::class, 'model_id');
    }

    public function vpicRecord()
    {
        return $this->hasOne(VpicVehicle::class, 'vin', 'vin');
    }

// Convenience accessors:
    public function getMakeAttribute()
    {
        return $this->vpicRecord?->Make;
    }
    public function getModelAttribute()
    {
        return $this->vpicRecord?->Model;
    }
    public function getYearAttribute()
    {
        return $this->vpicRecord?->ModelYear;
    }
}
