<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $dummyProducts = [
            [
                'name' => 'Laptop Gaming',
                'description' => 'Laptop high performance untuk gaming dan kerja',
                'price' => 15000000,
                'stock' => 10,
                'sku' => 'LAP-GAME-001',
                'is_active' => true,
            ],
            [
                'name' => 'Mouse Wireless',
                'description' => 'Mouse tanpa kabel, nyaman digunakan',
                'price' => 250000,
                'stock' => 50,
                'sku' => 'MOUSE-WL-002',
                'is_active' => true,
            ],
            [
                'name' => 'Keyboard Mechanical',
                'description' => 'Keyboard dengan switch blue, tactile dan clicky',
                'price' => 700000,
                'stock' => 30,
                'sku' => 'KEY-MECH-003',
                'is_active' => true,
            ],
            [
                'name' => 'Monitor 24 Inch',
                'description' => 'Monitor full HD, cocok untuk kerja dan gaming',
                'price' => 2000000,
                'stock' => 15,
                'sku' => 'MON-24HD-004',
                'is_active' => true,
            ],
            [
                'name' => 'Headset Bluetooth',
                'description' => 'Headset wireless dengan kualitas suara jernih',
                'price' => 350000,
                'stock' => 25,
                'sku' => 'HEAD-BT-005',
                'is_active' => true,
            ],
        ];

        foreach ($dummyProducts as $data) {
            Product::create($data);
        }
    }
}
