<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_banned')->default(false)->after('is_admin');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('is_approved')->default(true)->after('comment');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedInteger('discount_percent');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('categories');

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('is_approved');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_banned');
        });
    }
};
