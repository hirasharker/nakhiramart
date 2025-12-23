<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductStock;
use App\Models\OrderStatus;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Order Statuses
        $this->seedOrderStatuses();
        
        // Create Categories
        $this->seedCategories();
        
        // Create Products with Images
        $this->seedProducts();
        
        // Create Product Stock Records
        $this->seedProductStocks();
        
        // Create Sample Users
        $this->seedUsers();
        
        // Create Sample Customers
        $this->seedCustomers();
        
        // Create Sample Sellers
        $this->seedSellers();

        $this->command->info('✅ Database seeded successfully with all products and stock!');
    }

    protected function seedOrderStatuses()
    {
        $statuses = [
            ['name' => 'Pending', 'description' => 'Order placed, awaiting processing'],
            ['name' => 'Processing', 'description' => 'Order is being prepared'],
            ['name' => 'Shipped', 'description' => 'Order has been shipped'],
            ['name' => 'Delivered', 'description' => 'Order has been delivered'],
            ['name' => 'Cancelled', 'description' => 'Order has been cancelled'],
        ];

        foreach ($statuses as $status) {
            OrderStatus::firstOrCreate(['name' => $status['name']], $status);
        }

        $this->command->info('✓ Order statuses created');
    }

    protected function seedCategories()
    {
        $categories = [
            ['name' => 'Laptops', 'description' => 'Powerful laptops for work and play', 'slug' => 'laptops'],
            ['name' => 'Audio', 'description' => 'Premium headphones and speakers', 'slug' => 'audio'],
            ['name' => 'Phones', 'description' => 'Latest smartphones and accessories', 'slug' => 'phones'],
            ['name' => 'Wearables', 'description' => 'Smartwatches and fitness trackers', 'slug' => 'wearables'],
            ['name' => 'Tablets', 'description' => 'Versatile tablets for every need', 'slug' => 'tablets'],
            ['name' => 'Cameras', 'description' => 'Professional cameras and lenses', 'slug' => 'cameras'],
            ['name' => 'Gaming', 'description' => 'Gaming consoles and accessories', 'slug' => 'gaming'],
            ['name' => 'Speakers', 'description' => 'Wireless and Bluetooth speakers', 'slug' => 'speakers'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }

        $this->command->info('✓ Categories created');
    }

    protected function seedProducts()
    {
        // All products from your index.blade.php
        $products = [
            // Product 1 - MacBook Pro
            [
                'category' => 'Laptops',
                'sku' => 'LAP-MBP-001',
                'name' => 'MacBook Pro 16-inch M3 Max',
                'description' => 'Supercharged by M3 Max chip with up to 40-core GPU. Up to 128GB unified memory. 16.2-inch Liquid Retina XDR display. The most powerful MacBook Pro ever.',
                'price' => 2499.00,
                'stock_quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1511385348-a52b4a160dc2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsYXB0b3AlMjBjb21wdXRlcnxlbnwxfHx8fDE3NjUwMTM1MTN8MA&ixlib=rb-4.1.0&q=80&w=1080',
                'alt_text' => 'MacBook Pro 16-inch with M3 Max chip'
            ],
            // Product 2 - Sony Headphones
            [
                'category' => 'Audio',
                'sku' => 'AUD-SONY-001',
                'name' => 'Sony WH-1000XM5 Wireless Headphones',
                'description' => 'Industry-leading noise cancellation. Crystal clear hands-free calling. Up to 30-hour battery life. Premium comfort and sound.',
                'price' => 349.00,
                'stock_quantity' => 50,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx3aXJlbGVzcyUyMGhlYWRwaG9uZXN8ZW58MXx8fHwxNzY0OTgwNDg0fDA&ixlib=rb-4.1.0&q=80&w=1080',
                'alt_text' => 'Sony WH-1000XM5 wireless noise cancelling headphones'
            ],
            // Product 3 - iPhone
            [
                'category' => 'Phones',
                'sku' => 'PHN-IPH-001',
                'name' => 'iPhone 15 Pro Max 256GB',
                'description' => 'Titanium design. A17 Pro chip. Action button. 48MP main camera with 5x optical zoom. ProRes video recording.',
                'price' => 1199.00,
                'stock_quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1741061963569-9d0ef54d10d2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzbWFydHBob25lJTIwbW9iaWxlfGVufDF8fHx8MTc2NDk4NjQwMHww&ixlib=rb-4.1.0&q=80&w=1080',
                'alt_text' => 'iPhone 15 Pro Max titanium smartphone'
            ],
            // Product 4 - Apple Watch
            [
                'category' => 'Wearables',
                'sku' => 'WER-APW-001',
                'name' => 'Apple Watch Series 9 GPS',
                'description' => 'Advanced health and fitness tracking. Brighter display. Powerful S9 chip. Double tap gesture. Up to 18 hours battery.',
                'price' => 399.00,
                'stock_quantity' => 60,
                'image' => 'https://images.unsplash.com/photo-1660844817855-3ecc7ef21f12?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzbWFydHdhdGNofGVufDF8fHx8MTc2NTAzNzgxM3ww&ixlib=rb-4.1.0&q=80&w=1080',
                'alt_text' => 'Apple Watch Series 9 with midnight aluminum case'
            ],
            // Product 5 - iPad Pro
            [
                'category' => 'Tablets',
                'sku' => 'TAB-IPD-001',
                'name' => 'iPad Pro 12.9-inch M2 Chip',
                'description' => 'Astonishing performance with M2 chip. Liquid Retina XDR display. ProMotion technology. All-day battery life. Works with Apple Pencil.',
                'price' => 1099.00,
                'stock_quantity' => 30,
                'image' => 'https://images.unsplash.com/photo-1760708369071-e8a50a8979cb?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx0YWJsZXQlMjBkZXZpY2V8ZW58MXx8fHwxNzY1MDI1NzIyfDA&ixlib=rb-4.1.0&q=80&w=1080',
                'alt_text' => 'iPad Pro 12.9-inch with M2 chip and Magic Keyboard'
            ],
            // Product 6 - Canon Camera
            [
                'category' => 'Cameras',
                'sku' => 'CAM-CAN-001',
                'name' => 'Canon EOS R6 Mark II Camera',
                'description' => 'Professional mirrorless camera with 24.2MP full-frame sensor. 40fps continuous shooting. 6K video. In-body image stabilization.',
                'price' => 2499.00,
                'stock_quantity' => 15,
                'image' => 'https://images.unsplash.com/photo-1579535984712-92fffbbaa266?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjYW1lcmElMjBwaG90b2dyYXBoeXxlbnwxfHx8fDE3NjUwNDU4OTh8MA&ixlib=rb-4.1.0&q=80&w=1080',
                'alt_text' => 'Canon EOS R6 Mark II mirrorless camera body'
            ],
            // Product 7 - PlayStation 5
            [
                'category' => 'Gaming',
                'sku' => 'GAM-PS5-001',
                'name' => 'PlayStation 5 Console',
                'description' => 'Next-gen gaming console with stunning graphics. Ultra-high speed SSD. Haptic feedback. 4K gaming up to 120fps. Ray tracing.',
                'price' => 499.00,
                'stock_quantity' => 20,
                'image' => 'https://images.unsplash.com/photo-1580234797602-22c37b2a6230?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxnYW1pbmclMjBjb25zb2xlfGVufDF8fHx8MTc2NTA3NjM5NXww&ixlib=rb-4.1.0&q=80&w=1080',
                'alt_text' => 'PlayStation 5 gaming console with DualSense controller'
            ],
            // Product 8 - Bose Speaker
            [
                'category' => 'Speakers',
                'sku' => 'SPK-BOS-001',
                'name' => 'Bose SoundLink Revolve+ II',
                'description' => 'Portable Bluetooth speaker with 360° sound. Up to 17 hours battery life. Waterproof design. Deep, loud bass.',
                'price' => 329.00,
                'stock_quantity' => 45,
                'image' => 'https://images.unsplash.com/photo-1674303324806-7018a739ed11?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx3aXJlbGVzcyUyMHNwZWFrZXJ8ZW58MXx8fHwxNzY1MDM3NjE5fDA&ixlib=rb-4.1.0&q=80&w=1080',
                'alt_text' => 'Bose SoundLink Revolve+ II portable Bluetooth speaker'
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('name', $productData['category'])->first();
            
            if (!$category) {
                $this->command->warn("Category '{$productData['category']}' not found, skipping product: {$productData['name']}");
                continue;
            }

            // Create product
            $product = Product::updateOrCreate(
                ['sku' => $productData['sku']],
                [
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock_quantity' => $productData['stock_quantity'],
                    'category_id' => $category->id,
                    'is_active' => true
                ]
            );

            // Create product image
            ProductImage::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'is_primary' => true
                ],
                [
                    'image_path' => $productData['image'],
                    'alt_text' => $productData['alt_text'],
                    'sort_order' => 0,
                    'size' => '1080x1080',
                ]
            );

            $this->command->info("✓ Created: {$product->name}");
        }

        $this->command->info('✓ All products created with images');
    }

    protected function seedProductStocks()
    {
        $products = Product::all();

        foreach ($products as $product) {
            // Create main stock record for each product
            ProductStock::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'seller_id' => null,
                    'warehouse_location' => 'Main Warehouse'
                ],
                [
                    'quantity' => $product->stock_quantity,
                    'reserved_quantity' => 0,
                    'reorder_level' => 10
                ]
            );
            
            $this->command->info("✓ Stock: {$product->name} - {$product->stock_quantity} units");
        }

        $this->command->info('✓ Product stock records created');
    }

    protected function seedUsers()
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@techstore.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create test user
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✓ Users created (admin@techstore.com / user@example.com - password: password)');
    }

    protected function seedCustomers()
    {
        $customers = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+880123456789',
                'address1' => '123 Main Street, Gulshan',
                'address2' => 'Dhaka - 1212',
                'address3' => 'Bangladesh',
                'is_active' => true
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+880198765432',
                'address1' => '456 Lake Road, Banani',
                'address2' => 'Dhaka - 1213',
                'address3' => 'Bangladesh',
                'is_active' => true
            ],
        ];

        foreach ($customers as $customer) {
            Customer::firstOrCreate(['email' => $customer['email']], $customer);
        }

        $this->command->info('✓ Sample customers created');
    }

    protected function seedSellers()
    {
        $sellers = [
            [
                'name' => 'Tech Store BD',
                'email' => 'seller@techstore.com',
                'phone' => '+880987654321',
                'is_active' => true
            ],
            [
                'name' => 'Electronics Hub',
                'email' => 'seller@electronicshub.com',
                'phone' => '+880123123123',
                'is_active' => true
            ],
        ];

        foreach ($sellers as $seller) {
            Seller::firstOrCreate(['email' => $seller['email']], $seller);
        }

        $this->command->info('✓ Sample sellers created');
    }
}