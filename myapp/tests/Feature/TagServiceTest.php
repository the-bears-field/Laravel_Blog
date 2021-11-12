<?php

namespace Tests\Feature;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Services\TagServiceInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class TagServiceTest extends TestCase
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
    public function test_getAllメソッドが正常に作動するか()
    {
        $tagService = App::make(TagServiceInterface::class);
        $tags       = $tagService->getAll();
        $this->assertTrue($tags->isNotEmpty());
    }

    public function test_getTagメソッドが正常に作動するか()
    {
        $tagService = App::make(TagServiceInterface::class);
        $tags       = $tagService->getAll();

        foreach($tags as $tag){
            $tagInstance = $tagService->getTag($tag->name);
            $this->assertEquals($tagInstance::class, Tag::class);
        }
    }
}
