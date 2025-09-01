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
        Schema::create('coupon_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dealer_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->dateTime('start_at')->nullable();
            $table->dateTime('expires_at')->nullable()->index();
            $table->unsignedInteger('generation_limit')->nullable();
            $table->unsignedInteger('generation_count')->default(0)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_campaigns');
    }
};
