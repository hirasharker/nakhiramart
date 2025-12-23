<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductStock;

class ProductStockSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            // Create main stock record for each product
            ProductStock::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'seller_id' => null, // Main warehouse stock
                    'warehouse_location' => 'Main Warehouse'
                ],
                [
                    'quantity' => $product->stock_quantity,
                    'reserved_quantity' => 0,
                    'reorder_level' => 10
                ]
            );

            $this->command->info("✓ Stock created for: {$product->name} - Quantity: {$product->stock_quantity}");
        }

        $this->command->info('✅ Product stock seeding completed!');
    }
}