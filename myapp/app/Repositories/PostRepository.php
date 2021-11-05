<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function getAll(): Collection
    {
        $posts = Post::with('users')->with('tags')->latest('id')->get();
        return $posts;
    }

    public function getPost(int $postId)
    {
        $post = Post::with('users')->with('tags')->find($postId);
        return $post;
    }

    public function createPost(PostRequest $request): Post
    {
        $params = $request->only(['title', 'post']);
        return Post::create($params);
    }

    public function updatePost(PostRequest $request): void
    {
        $params = $request->only(['title', 'post']);
        Post::where('id', intval($request->postId))->update($params);
    }
}