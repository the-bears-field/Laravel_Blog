<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostServiceInterface
{
    public function getAll(): LengthAwarePaginator;
    public function getPost(int $postId);
    public function getPostForForm(int $postId);
    public function getPostsWithSearchWords(string $searchWords): LengthAwarePaginator;
    public function getPostsWithSearchTag(string $searchTag): LengthAwarePaginator;
    public function createPost($request): void;
    public function updatePost(PostRequest $request): void;
    public function deletePost(Request $request): void;
}
