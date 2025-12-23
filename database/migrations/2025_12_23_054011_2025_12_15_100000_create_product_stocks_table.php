<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('seller_id')->nullable()->constrained('sellers'); // For marketplace
            $table->string('warehouse_location', 100)->default('Main Warehouse');
            $table->integer('quantity')->default(0);
            $table->integer('reserved_quantity')->default(0); // For pending orders
            $table->integer('reorder_level')->default(10); // Alert threshold
            $table->timestamps();

            // Indexes
            $table->index(['product_id', 'seller_id']);
            $table->index('quantity');
            
            // Unique constraint: one stock record per product per seller per location
            $table->unique(['product_id', 'seller_id', 'warehouse_location']);
        });

        // Stock movement history table
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('product_stock_id')->constrained('product_stocks');
            $table->foreignId('user_id')->nullable()->constrained('users'); // Who made the change
            $table->enum('type', [
                'purchase',      // Stock added from supplier
                'sale',          // Stock sold to customer
                'return',        // Customer return
                'adjustment',    // Manual adjustment
                'damage',        // Damaged/lost items
                'transfer',      // Transfer between warehouses
                'reserved',      // Reserved for pending order
                'released'       // Released from reservation
            ]);
            $table->integer('quantity'); // Positive for increase, negative for decrease
            $table->integer('balance_after'); // Stock balance after this movement
            $table->string('reference_type', 50)->nullable(); // 'order', 'purchase', etc.
            $table->unsignedBigInteger('reference_id')->nullable(); // Order ID, Purchase ID, etc.
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('product_id');
            $table->index(['reference_type', 'reference_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('product_stocks');
    }
};
