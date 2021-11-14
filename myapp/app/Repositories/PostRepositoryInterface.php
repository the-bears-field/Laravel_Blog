<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface PostRepositoryInterface
{
    public function getAll(): Collection;
    public function getPost(int $postId);
    public function getPostsWithSearchWords(array $searchWords): Collection;
    public function createPost(PostRequest $request): Post;
    public function updatePost(PostRequest $request): void;
    public function deletePost(Request $request): void;
}