<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;

class PostTagAndUserModelTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $post;
    private $tag;

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

        $this->tag = Tag::factory()->create([
            'id' => 1,
            'name' => 'test'
        ]);

        $this->user->posts()->syncWithoutDetaching($this->post->id);
        $this->post->tags()->syncWithoutDetaching($this->tag->id);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserRegistration()
    {
        # usersテーブルに上記データが挿入できているか判定
        $this->assertDatabaseHas('users', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'test'
        ]);
    }

    public function testPosting()
    {
        # postsテーブルに上記データが挿入できているか判定
        $this->assertDatabaseHas('posts', [
            'title' => 'test',
            'post' => 'test'
        ]);
    }

    public function testTagRegistration()
    {
        # tagsテーブルに上記データが挿入できているか判定
        $this->assertDatabaseHas('tags', [
            'name' => 'test'
        ]);
    }

    public function testLinkedPostUserTable()
    {
        $user = $this->user;
        $post = $this->post;
        # 中間テーブルにレコードが存在するかを判定
        $this->assertDatabaseHas('post_user', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    public function testLinkedPostTagTable()
    {
        $post = $this->post;
        $tag = $this->tag;
        # 中間テーブルにレコードが存在するかを判定
        $this->assertDatabaseHas('post_tag', [
            'post_id' => $post->id,
            'tag_id' => $tag->id
        ]);
    }

    public function testGetPostModelInstanceFromUserModel()
    {
        # Userモデルから投稿を取得できているかを判定
        $user = $this->user;
        $userId = $user->id;
        $postId = $this->post->id;
        $post = $user->with('posts')->find($userId)->posts->find($postId);
        $this->assertEquals($post->title, 'test');
        $this->assertEquals($post->post, 'test');
    }

    public function testGetUserModelInstanceFromPostModel()
    {
        # Postモデルからユーザー情報を取得できているかを判定
        $post = $this->post;
        $userId = $this->user->id;
        $postId = $post->id;
        $user = $post->with('users')->find($postId)->users->find($userId);
        $this->assertEquals($user->name, 'test');
        $this->assertEquals($user->email, 'test@example.com');
        $this->assertEquals($user->password, 'test');
    }

    public function testUnlinkPostTagAndDeleteTag()
    {
        $post = $this->post;
        $postId = $post->id;
        $tagId = $this->tag->id;
        $post->tags()->detach($tagId);
        # 中間テーブルとの紐付けを解除して、中間テーブルのレコードが削除されているか判定。
        $this->assertDatabaseMissing('post_tag', [
            'post_id' => $postId,
            'tag_id' => $tagId
        ]);
    }

    public function testDeletePostUnlinkedTagAndUser()
    {
        $user = $this->user;
        $post = $this->post;
        $tag  = $this->tag;
        $postId = $post->id;
        $userId = $user->id;
        $tagId = $tag->id;

        $post->tags()->detach($tagId);
        # 中間テーブルとの紐付けを解除して、中間テーブルのレコードが削除されているか判定。
        $this->assertDatabaseMissing('post_tag', [
            'post_id' => $postId,
            'tag_id' => $tagId
        ]);

        # 中間テーブルとの紐付けを解除して、中間テーブルのレコードが削除されているか判定。
        $user->posts()->detach($postId);
        $this->assertDatabaseMissing('post_user', [
            'user_id' => $userId,
            'post_id' => $postId
        ]);

        # 中間テーブルとの紐付けを解除した後、postsのレコードを削除できているか判定。
        $post->where('id', $post->id)->delete();
        $this->assertDatabaseMissing('posts', [
            'title' => 'test',
            'post' => 'test'
        ]);
    }
}
