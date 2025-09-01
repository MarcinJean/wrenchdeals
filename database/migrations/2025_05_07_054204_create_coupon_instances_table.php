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
        Schema::create('coupon_instances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')
                ->constrained('coupon_campaigns')
                ->cascadeOnDelete()
                ->index();
            $table->string('code')->unique();
            $table->enum('status', ['guest','issued','redeemed']);
            $table->foreignId('user_id')->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('guest_contact')->nullable();
            $table->dateTime('redeemed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_instances');
    }
};
