<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MarcinJean\LaravelVPic\Facades\VPic;
use App\Models\VehicleMake;

class SeedVehicleMakes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vpic:seed-makes {--force : Overwrite existing makes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync vehicle makes from the NHTSA vPIC API into vehicle_makes table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Fetching makes from vPIC API...');
        $allMakes = Vpic::allMakes(); // returns array of make names

        foreach ($allMakes as $makeName) {
            $makeName = trim($makeName);
            if (empty($makeName)) continue;

            $model = VehicleMake::firstOrNew(['name' => $makeName]);
            if ($model->exists && ! $this->option('force')) {
                continue;
            }
            $model->name = $makeName;
            $model->save();
        }

        // Ensure 'Other' exists
        VehicleMake::firstOrCreate(['name' => 'Other']);

        $this->info('Vehicle makes synced successfully.');

        return 0;
    }
}
