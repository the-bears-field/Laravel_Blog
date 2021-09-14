<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class PostAndUserModelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostAndUserModel()
    {
        $user = User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'test'
        ]);

        # usersテーブルに上記データが挿入できているか判定
        $this->assertDatabaseHas('users', [
            'id' => 1,
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'test'
        ]);

        $post = Post::factory()->create([
            'title' => 'test',
            'post' => 'test'
        ]);

        # postsテーブルに上記データが挿入できているか判定
        $this->assertDatabaseHas('posts', [
            'id' => 1,
            'title' => 'test',
            'post' => 'test'
        ]);

        $user->posts()->attach($post->id);

        $i = $post->id;
        while ($i < 10) {
            $post = Post::factory()->create();
            $postId = $post->id;
            $user->posts()->attach($postId);
            $i++;
        }

        # Userモデルから投稿を取得できているかを判定
        $post = User::with('posts')->find(1)->posts->find(1);
        $this->assertEquals($post->title, 'test');

        # Postモデルからユーザー情報を取得できているかを判定
        $user = Post::with('users')->find(1)->users->find(1);
        $this->assertEquals($user->name, 'test');
        $this->assertEquals($user->email, 'test@example.com');
        $this->assertEquals($user->password, 'test');

        # 中間テーブルにレコードが存在するかを判定
        $this->assertDatabaseHas('post_user', [
            'user_id' => 1,
            'post_id' => 1,
        ]);

        # 中間テーブルとの紐付けを解除して、中間テーブルのレコードが削除されているか判定。
        $user->posts()->detach(1);
        $this->assertDatabaseMissing('post_user', [
            'user_id' => 1,
            'post_id' => 1,
        ]);

        # 中間テーブルとの紐付けを解除した後、postsのレコードを削除できているか判定。
        DB::table('posts')->where('id', 1)->delete();
        $this->assertDatabaseMissing('posts', [
            'id' => 1,
            'title' => 'test',
            'post' => 'test'
        ]);
    }
}
