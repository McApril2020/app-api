<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'id' => 1,
            'name' => 'Product 1',
            'available_stock' => 10,
        ]);

        Product::create([
            'id' => 2,
            'name' => 'Product 2',
            'available_stock' => 0, // Simulating out of stock
        ]);
    }
}
