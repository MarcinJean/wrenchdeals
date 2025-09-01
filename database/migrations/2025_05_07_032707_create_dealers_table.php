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
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dealer_group_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('timezone')->default('UTC');
            $table->enum('status', ['active','offboarded'])
                ->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealers');
    }
};
