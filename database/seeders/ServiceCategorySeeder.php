<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Oil Change',
            'Brake Service',
            'Tire Rotation',
            'Battery Replacement',
            'Wheel Alignment',
            'Transmission Service',
            'Engine Diagnostics',
        ];

        foreach ($categories as $name) {
            ServiceCategory::firstOrCreate(['name' => $name]);
        }
    }
}
