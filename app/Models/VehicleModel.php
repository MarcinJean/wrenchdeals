<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['make_id', 'name'];

    public function make()
    {
        return $this->belongsTo(VehicleMake::class, 'make_id');
    }
}
