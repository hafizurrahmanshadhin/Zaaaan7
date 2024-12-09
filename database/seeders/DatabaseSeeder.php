<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);

        // Create 10 categories, each with 5 subcategories
        Category::factory(10)
            ->withImage() // Ensure each category has an associated image
            ->create()
            ->each(function ($category) {
                // Create 5 subcategories for each category
                SubCategory::factory(5)->create([
                    'category_id' => $category->id,
                ]);
            });
    }
}