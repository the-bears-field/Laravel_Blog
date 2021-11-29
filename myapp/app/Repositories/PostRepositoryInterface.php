<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function getAll(): LengthAwarePaginator;
    public function getPost(int $postId);
    public function getPostsWithSearchWords(array $searchWords): LengthAwarePaginator;
    public function getPostsWithSearchTag(string $searchTag): LengthAwarePaginator;
    public function createPost(PostRequest $request): Post;
    public function updatePost(PostRequest $request): void;
    public function deletePost(int $postId): void;
}