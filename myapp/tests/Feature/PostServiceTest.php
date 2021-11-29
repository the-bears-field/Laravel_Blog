<?php

namespace Tests\Feature;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Services\PostServiceInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    use DatabaseMigrations;

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

        $this->user->posts()->syncWithoutDetaching($this->post->id);

        $this->tags = Tag::factory()
                        ->count(10)
                        ->create()
                        ->each(function($tag){
                            $tag->posts()->syncWithoutDetaching($this->post->id);
                        });
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
            'post'  => '<p>example</p>',
            'tags'  => 'example1 example2 example3',
        ];
        $request->merge($params);

        $postService = App::make(PostServiceInterface::class);
        $postService->createPost($request);

        $this->assertDatabaseHas('posts', [
            'title' => 'example',
            'post'  => '<p>example</p>'
        ]);

        $verificationTagNames = ['example1', 'example2', 'example3'];

        foreach($verificationTagNames as $tagName){
            $this->assertDatabaseHas('tags', [
                'name' => $tagName
            ]);
        }
    }

    public function test_createPostメソッドでのエスケープ処理が正常に作動するか検証()
    {
        $this->actingAs($this->user);

        $request = new PostRequest;
        $params  = [
            'title' => 'XSS test',
            'post'  => '<p>a</p><script>alert("!!!");</script>',
            'tags'  => 'example1 example2 example3',
        ];
        $request->merge($params);

        $postService = App::make(PostServiceInterface::class);
        $postService->createPost($request);
        $post = $postService->getPost(2);

        $this->assertDatabaseMissing('posts', [
            'post' => '<p>a</p><script>alert("!!!");</script>'
        ]);

        $this->assertDatabaseHas('posts', [
            'post' => '<p>a</p>'
        ]);

        $this->assertFalse($post->post === '<p>a</p><script>alert("!!!");</script>');
        $this->assertTrue($post->post === '<p>a</p>');
    }

    public function test_updatePostメソッドが正常に作動する()
    {
        $this->actingAs($this->user);

        $request = new PostRequest;
        $params  = [
            'postId' => '1',
            'title'  => 'example',
            'post'   => '<p>example</p>',
            'tags'   => 'test',
        ];
        $request->merge($params);

        $postService = App::make(PostServiceInterface::class);
        $postService->updatePost($request);

        $this->assertDatabaseHas('posts', [
            'id'    => 1,
            'title' => 'example',
            'post'  => '<p>example</p>'
        ]);

        $this->assertDatabaseHas('tags', [
            'id'   => 11,
            'name' => 'test'
        ]);

        $this->assertDatabaseHas('post_tag', [
            'post_id' => 1,
            'tag_id'  => 11
        ]);

        $params  = [
            'postId' => '1',
            'title'  => 'test',
            'post'   => '<p>test</p>',
            'tags'   => 'test2',
        ];
        $request->merge($params);
        $postService->updatePost($request);

        $this->assertDatabaseHas('posts', [
            'id'    => 1,
            'title' => 'test',
            'post'  => '<p>test</p>'
        ]);

        $this->assertDatabaseHas('tags', [
            'id'   => 12,
            'name' => 'test2'
        ]);

        $this->assertDatabaseMissing('tags', [
            'id'   => 11,
            'name' => 'test'
        ]);

        $this->assertDatabaseHas('post_tag', [
            'post_id' => 1,
            'tag_id'  => 12
        ]);

        $this->assertDatabaseMissing('post_tag', [
            'post_id' => 1,
            'tag_id'  => 11
        ]);
    }

    public function test_updatePostメソッドでのエスケープ処理が正常に作動するか検証()
    {
        $this->actingAs($this->user);

        $request = new PostRequest;
        $params  = [
            'postId' => '1',
            'title'  => 'XSS Attack',
            'post'   => '<p>a</p><script>alert("!!!");</script>',
            'tags'   => 'XSS',
        ];
        $request->merge($params);

        $postService = App::make(PostServiceInterface::class);
        $postService->updatePost($request);

        $post = $postService->getPost(1);

        $this->assertDatabaseMissing('posts', [
            'id'   => 1,
            'post' => '<p>a</p><script>alert("!!!");</script>'
        ]);

        $this->assertDatabaseHas('posts', [
            'id'   => 1,
            'post' => '<p>a</p>'
        ]);

        $this->assertFalse($post->post === '<p>a</p><script>alert("!!!");</script>');
        $this->assertTrue($post->post === '<p>a</p>');
    }

    public function test_deletePostメソッドが正常に作動する()
    {
        $this->actingAs($this->user);

        $postId = 1;

        $this->assertDatabaseHas('posts', [
            'id'    => 1,
            'title' => 'test',
            'post'  => 'test'
        ]);

        $this->assertDatabaseHas('post_tag', [
            'post_id' => 1
        ]);

        $postService = App::make(PostServiceInterface::class);
        $postService->deletePost($postId);

        $this->assertDatabaseMissing('posts', [
            'id'    => 1,
            'title' => 'test',
            'post'  => 'test'
        ]);

        $this->assertDatabaseMissing('post_tag', [
            'post_id' => 1
        ]);

        $this->assertDatabaseMissing('post_user', [
            'post_id' => 1
        ]);
    }

    public function test_getPostsWithSearchWordsメソッドで検索に応じた結果が返ってくるか検証()
    {
        $this->actingAs($this->user);

        $request = new PostRequest;
        $params  = [
            'title' => 'Steve Jobs wise saying.',
            'post'  => 'Stay Hungry. Stay Foolish.',
            'tags'  => 'Steve_Jobs Wise_saying Stanford_University Speech Apple',
        ];
        $request->merge($params);

        $postService = App::make(PostServiceInterface::class);
        $postService->createPost($request);

        $searchWords = 'Hungry Foolish';
        $posts = $postService->getPostsWithSearchWords($searchWords);
        $this->assertTrue($posts->isNotEmpty());
    }
}
