<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    public function getAll(): Collection;
    public function getPost(int $postId);
    public function createPost(PostRequest $request): Post;
}