<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $post;
    private $tags;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'id' => 1,
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'test'
        ]);

        $this->post = Post::factory()->create([
            'id' => 1,
            'title' => 'test',
            'post' => 'test'
        ]);

        $this->tags = Tag::factory()->count(10)->create();

        $this->user->posts()->syncWithoutDetaching($this->post->id);

        foreach($this->tags as $tag){
            $this->post->tags()->syncWithoutDetaching($tag->id);
        }
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getAllメソッドで記事一覧が取得可能()
    {
        $postService = App::make(PostService::class);
        $post = $postService->getAll();
        $this->assertTrue($post->isNotEmpty());
    }
}
