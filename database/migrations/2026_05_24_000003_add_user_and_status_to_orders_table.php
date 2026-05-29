<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->string('status')->default('Pending')->after('products');
            $table->string('shipping_address')->nullable()->after('customer_email');
            $table->string('shipping_city')->nullable()->after('shipping_address');
            $table->string('customer_phone')->nullable()->after('shipping_city');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'status',
                'shipping_address',
                'shipping_city',
                'customer_phone',
            ]);
        });
    }
};
