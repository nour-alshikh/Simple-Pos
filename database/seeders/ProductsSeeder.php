<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = ['product 1', 'product 2', 'product 3', 'product 4', 'product 5'];

        DB::table('products')->delete();

        foreach ($products as $product) {
            Product::create([
                'category_id' => random_int(1, 2),
                'name' => $product,
                'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore mollitia dicta reprehenderit nesciunt cum quasi sequi quos! Recusandae, consequatur dolorum?",
                'purchase_price' => random_int(1, 150),
                'sell_price' => random_int(151, 300),
                'stock' => random_int(1, 150),
            ]);
        }
    }
}
