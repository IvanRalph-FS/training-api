<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\TestCase;

class ArticleTest extends \Tests\TestCase
{
    public function testUserCanSeeArticlesList()
    {
        $user = User::factory()->create();

        ArticleCategory::factory(10)->create();
        Article::factory(10)->create();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/articles');

        $response->assertJsonStructure([
            'data',
        ]);
    }

    public function testUserCanCreateArticle()
    {
        User::factory(10)->create();
        ArticleCategory::factory(10)->create();

        $data = [
            'article_category_id' => $this->faker->randomElement(ArticleCategory::pluck('id')),
            'title' => $this->faker->title,
            'slug' => $this->faker->slug,
            'contents' => $this->faker->paragraph,
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ];

        $user = User::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/articles', $data);

        $response->assertCreated();

        $response->assertJsonStructure([
            'data'
        ]);
    }

    public function testUserCanUpdateArticle()
    {
        User::factory(10)->create();
        ArticleCategory::factory(10)->create();
        $article = Article::factory()->create();

        $data = [
            'article_category_id' => $this->faker->randomElement(ArticleCategory::pluck('id')),
            'title' => $this->faker->title,
            'slug' => $this->faker->slug,
            'contents' => $this->faker->paragraph,
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ];

        $user = User::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->put('/api/articles/' . $article->id, $data);

        $this->assertEquals('1', $response->getOriginalContent());
    }

    public function testUserCanDeleteArticle()
    {
        User::factory(10)->create();
        ArticleCategory::factory(10)->create();
        $article = Article::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->delete('/api/articles/' . $article->id);

        $this->assertSoftDeleted($article->refresh());
    }
}
