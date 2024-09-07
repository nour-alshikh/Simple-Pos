<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['cat 1', 'cat 2', 'cat 3'];

        DB::table('categories')->delete();

        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }
    }
}
