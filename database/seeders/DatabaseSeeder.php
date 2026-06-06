<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@techhouse.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Manager TechHouse',
            'email' => 'manager@techhouse.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'email_verified_at' => now(),
        ]);

        $categories = [
            ['name' => 'Laptop', 'description' => 'Kategori laptop dan notebook'],
            ['name' => 'Storage', 'description' => 'SSD, HDD, dan media penyimpanan'],
            ['name' => 'Networking', 'description' => 'Router, switch, dan perangkat jaringan'],
            ['name' => 'Aksesoris', 'description' => 'Mouse, keyboard, dan aksesoris lainnya'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $items = [
            ['kode' => 'BRG001', 'category_id' => 1, 'name' => 'ASUS TUF Gaming F15', 'merek' => 'ASUS', 'stock' => 10, 'minimum_stock' => 5, 'satuan' => 'Unit'],
            ['kode' => 'BRG002', 'category_id' => 2, 'name' => 'Samsung SSD 1TB', 'merek' => 'Samsung', 'stock' => 25, 'minimum_stock' => 5, 'satuan' => 'Pcs'],
            ['kode' => 'BRG003', 'category_id' => 3, 'name' => 'TP-Link Archer C6', 'merek' => 'TP-Link', 'stock' => 8, 'minimum_stock' => 3, 'satuan' => 'Unit'],
            ['kode' => 'BRG004', 'category_id' => 4, 'name' => 'Logitech G502 Hero', 'merek' => 'Logitech', 'stock' => 3, 'minimum_stock' => 5, 'satuan' => 'Pcs'],
            ['kode' => 'BRG005', 'category_id' => 2, 'name' => 'Seagate HDD 2TB', 'merek' => 'Seagate', 'stock' => 0, 'minimum_stock' => 5, 'satuan' => 'Pcs'],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
