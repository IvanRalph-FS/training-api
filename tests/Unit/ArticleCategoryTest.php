<?php

namespace Tests\Unit;

use App\Models\ArticleCategory;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class ArticleCategoryTest extends \Tests\TestCase
{
    public function testUserCanSeeCateogoryList()
    {
        $user = User::factory()->create();

        ArticleCategory::factory(10)->create();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/article-categories');

        $response->assertJsonStructure(['data']);
        $response->assertOk();
    }

    public function testUserCanCreateCategory()
    {
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->word
        ];

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/article-categories', $data);

        $response->assertCreated();

        $response->assertJsonStructure([
            'data',
        ]);
    }

    public function testUserCanUpdateCategory()
    {
        $data = [
            'name' => $this->faker->word
        ];

        $user = User::factory()->create();
        $category = ArticleCategory::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/article-categories/' . $category->id, $data);

        $this->assertEquals('1', $response->getOriginalContent());
    }

    public function testUserCanDeleteCategory()
    {
        $user = User::factory()->create();
        $articleCategory = ArticleCategory::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->delete('/api/article-categories/' . $user->id);

        $this->assertSoftDeleted($articleCategory->refresh());
    }
}
