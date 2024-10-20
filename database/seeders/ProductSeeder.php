<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Notebook', 'price' => 3500.00, "stock" => 40],
            ['name' => 'Smartphone', 'price' => 1500.00, "stock" => 50],
            ['name' => 'Teclado Mecânico', 'price' => 300.00, "stock" => 60],
            ['name' => 'Monitor Full HD', 'price' => 900.00, "stock" => 70],
            ['name' => 'Mouse Gamer', 'price' => 120.00, "stock" => 80],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
