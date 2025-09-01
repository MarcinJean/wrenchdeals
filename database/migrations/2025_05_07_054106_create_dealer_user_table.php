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
        Schema::create('dealer_user', function (Blueprint $table) {
            $table->foreignId('dealer_id')
                ->constrained()
                ->cascadeOnDelete()
                ->index();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->index();
            $table->string('title')->nullable(); // Advisor, Service Manager, etc.
            $table->timestamps();
            $table->primary(['dealer_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealer_user');
    }
};
