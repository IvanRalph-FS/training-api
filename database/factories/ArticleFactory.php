<?php

namespace Database\Factories;

use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'article_category_id' => $this->faker->randomElement(ArticleCategory::pluck('id')),
            'title' => $this->faker->title,
            'slug' => $this->faker->slug,
            'contents' => $this->faker->paragraph,
            'image_path' => $this->faker->imageUrl,
            'updated_user_id' => $this->faker->randomElement(User::pluck('id')),
        ];
    }
}
