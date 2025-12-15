<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('order_date');
            $table->dateTime('shipped_date')->nullable();
            $table->string('billing_address', 500)->nullable();
            $table->string('shipping_address', 500)->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->foreignId('order_status_id')->default(1)->constrained('order_statuses');
            $table->string('payment_method', 100)->nullable();
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};