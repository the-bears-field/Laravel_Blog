<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function getAll(): Collection
    {
        $post = Post::with('users')->with('tags')->latest()->get();
        return $post;
    }
}