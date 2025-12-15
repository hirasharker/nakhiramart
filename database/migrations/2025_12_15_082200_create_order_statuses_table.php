<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default statuses
        DB::table('order_statuses')->insert([
            ['name' => 'Pending', 'description' => 'Order placed, awaiting processing'],
            ['name' => 'Processing', 'description' => 'Order is being prepared'],
            ['name' => 'Shipped', 'description' => 'Order has been shipped'],
            ['name' => 'Delivered', 'description' => 'Order has been delivered'],
            ['name' => 'Cancelled', 'description' => 'Order has been cancelled'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};