<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('coupon_instances', function (Blueprint $table) {
            $table->foreignId('staff_user_id')->nullable()->constrained('users')->nullOnDelete()->after('guest_contact');
            $table->string('repair_order_id')->nullable()->after('staff_user_id');
        });
    }

    public function down(): void
    {
        Schema::table('coupon_instances', function (Blueprint $table) {
            $table->dropColumn(['staff_user_id', 'repair_order_id']);
        });
    }
};
