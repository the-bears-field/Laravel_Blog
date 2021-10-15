<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function getAll(): Collection
    {
        $posts = Post::with('users')->with('tags')->latest()->get();
        return $posts;
    }

    public function getPost(int $postId)
    {
        $post = Post::with('users')->with('tags')->find($postId);
        return $post;
    }
}