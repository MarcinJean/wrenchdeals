<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealerGroup extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    public function dealers()
    {
        return $this->hasMany(Dealer::class);
    }
}
