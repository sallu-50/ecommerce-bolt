<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create categories
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Books', 'slug' => 'books'],
            ['name' => 'Home Goods', 'slug' => 'home-goods'],
            ['name' => 'Clothing', 'slug' => 'clothing'],
            ['name' => 'Toys', 'slug' => 'toys'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create products
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $productName = $faker->sentence(3);
            $imageUrl = 'https://picsum.photos/seed/' . Str::slug($productName) . '/640/480';

            Product::create([
                'name' => $productName,
                'slug' => Str::slug($productName),
                'description' => $faker->paragraph,
                'price' => $faker->randomFloat(2, 10, 1000),
                'quantity' => $faker->numberBetween(1, 100),
                'featured' => $faker->boolean,
                'image' => $imageUrl,
                'category_id' => Category::inRandomOrder()->first()->id,
            ]);
        }
    }
}
