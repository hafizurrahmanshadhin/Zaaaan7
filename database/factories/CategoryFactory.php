<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'cost' => $this->faker->randomFloat(2, 10, 100),
            'provision' => $this->faker->randomFloat(2, 5, 50),
        ];
    }



    /**
     * Create an image for the category.
     */
    public function withImage(): self
    {
        return $this->afterCreating(function (Category $category) {
            // Create an image and associate it with the category
            Image::create([
                'imageable_type' => Category::class,
                'imageable_id' => $category->id,
                'url' => $this->faker->imageUrl(640, 480, 'business', true, 'category'),
            ]);
        });
    }
}
