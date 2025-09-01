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
        Schema::create('coupon_campaign_service_category', function (Blueprint $table) {
            $table->foreignId('coupon_campaign_id')
                ->constrained('coupon_campaigns')
                ->cascadeOnDelete()
                ->index();
            $table->foreignId('service_category_id')
                ->constrained()
                ->cascadeOnDelete()
                ->index();
            $table->primary(['coupon_campaign_id','service_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_campaign_service_category');
    }
};
