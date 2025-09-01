<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\Response;

class VehiclePolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vehicle $vehicle)
    {
        return $vehicle->user_id === $user->id;
    }
}
