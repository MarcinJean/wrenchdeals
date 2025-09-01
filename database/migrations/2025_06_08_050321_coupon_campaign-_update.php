<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('coupon_campaigns', function (Blueprint $table) {
            //$table->string('image')->default('');
            $table->string('title')->default('');
            $table->text('description')->default('');
            $table->string('discount')->default('');
            $table->text('disclaimer')->nullable();
            $table->string('color', 6)->nullable();
            $table->string('template')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupon_campaigns', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'description',
                'discount',
                'color',
                'disclaimer',
                'template',
            ]);
        });       //
    }
};
