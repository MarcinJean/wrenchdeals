<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dealer_vehicle_make', function (Blueprint $table) {
            $table->foreignId('dealer_id')
                ->constrained()
                ->cascadeOnDelete()
                ->index();
            $table->foreignId('vehicle_make_id')
                ->constrained()
                ->cascadeOnDelete()
                ->index();
            $table->primary(['dealer_id','vehicle_make_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealer_vehicle_make');
    }
};
