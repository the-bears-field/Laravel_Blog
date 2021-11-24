<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Services\UserServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class UserServiceTest extends TestCase
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
    public function test_updateUserメソッドが正常に作動するか()
    {
        $this->actingAs($this->user);

        $request = new Request;
        $request->merge([
            'name' => 'aaa'
        ]);

        $userService = App::make(UserServiceInterface::class);
        $userService->updateUser($request);

        $this->assertDatabaseHas('users', [
            'name'     => 'aaa',
            'email'    => 'test@example.com',
            'password' => 'test'
        ]);

        $request->merge([
            'email' => 'aaa@example.com'
        ]);
        $userService->updateUser($request);

        $this->assertDatabaseHas('users', [
            'name'     => 'aaa',
            'email'    => 'aaa@example.com',
            'password' => 'test'
        ]);

        $request->merge([
            'password' => 'aaa'
        ]);
        $userService->updateUser($request);

        $this->assertDatabaseHas('users', [
            'name'     => 'aaa',
            'email'    => 'aaa@example.com',
            'password' => 'aaa'
        ]);
    }
}
