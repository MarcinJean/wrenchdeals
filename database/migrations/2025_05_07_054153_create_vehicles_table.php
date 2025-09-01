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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('vin')->unique();
            $table->foreignId('make_id')
                ->constrained('vehicle_makes')
                ->cascadeOnDelete();
            $table->foreignId('model_id')
                ->constrained('vehicle_models')
                ->cascadeOnDelete();
            $table->integer('year')->nullable();
            $table->json('raw_decode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
