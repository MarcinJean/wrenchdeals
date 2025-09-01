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
        Schema::create('coupon_dealer', function (Blueprint $table) {
            $table->foreignId('coupon_campaign_id')
                ->constrained('coupon_campaigns')
                ->cascadeOnDelete()
                ->index();
            $table->foreignId('dealer_id')
                ->constrained()
                ->cascadeOnDelete()
                ->index();
            $table->primary(['coupon_campaign_id','dealer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_dealer');
    }
};
