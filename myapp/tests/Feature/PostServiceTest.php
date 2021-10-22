<?php

namespace Tests\Feature;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Services\PostServiceInterface;
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
        $postService = App::make(PostServiceInterface::class);
        $post = $postService->getAll();
        $this->assertTrue($post->isNotEmpty());
    }

    public function test_getPostメソッドでPostインスタンスが取得可能()
    {
        $postService = App::make(PostServiceInterface::class);
        $post = $postService->getPost(1);
        $this->assertEquals($post::class, Post::class);
    }

    public function test_createPostメソッドが正常に作動する()
    {
        $this->actingAs($this->user);

        $request = new PostRequest;
        $params  = [
            'title' => 'example',
            'post'  => 'example',
            'tags'  => 'example1 example2 example3',
        ];
        $request->merge($params);

        $postService = App::make(PostServiceInterface::class);
        $postService->createPost($request);

        $this->assertDatabaseHas('posts', [
            'title' => 'example',
            'post'  => 'example'
        ]);

        $verificationTagNames = ['example1', 'example2', 'example3'];

        foreach($verificationTagNames as $tagName){
            $this->assertDatabaseHas('tags', [
                'name' => $tagName
            ]);
        }
    }
}
