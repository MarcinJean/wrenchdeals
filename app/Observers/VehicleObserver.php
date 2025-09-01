<?php

namespace App\Observers;

use App\Models\Vehicle;
use Exception;
use Illuminate\Support\Facades\Log;
use MarcinJean\LaravelVPic\Facades\VPic;
class VehicleObserver
{
    /**
     * Handle the Vehicle "created" event.
     */
    public function created(Vehicle $vehicle): void
    {
        try {
            // This will cache the decoded record in vpic_vehicles
            Vpic::decode($vehicle->vin);
        } catch (Exception $e) {
            // Log failure, but don’t block user
            Log::warning("VPIC decode failed for VIN {$vehicle->vin}: {$e->getMessage()}");
        }
    }

    /**
     * Handle the Vehicle "updated" event.
     */
    public function updated(Vehicle $vehicle): void
    {
        //
    }

    /**
     * Handle the Vehicle "deleted" event.
     */
    public function deleted(Vehicle $vehicle): void
    {
        //
    }

    /**
     * Handle the Vehicle "restored" event.
     */
    public function restored(Vehicle $vehicle): void
    {
        //
    }

    /**
     * Handle the Vehicle "force deleted" event.
     */
    public function forceDeleted(Vehicle $vehicle): void
    {
        //
    }
}
