<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostServiceInterface
{
    public function getAll(): LengthAwarePaginator;
    public function getPost(int $postId);
    public function getPostForForm(int $postId);
    public function getPostsWithSearchWords(string $searchWords): LengthAwarePaginator;
    public function getPostsWithSearchTag(string $searchTag): LengthAwarePaginator;
    public function createPost(CreateRequest $request): void;
    public function updatePost(UpdateRequest $request): void;
    public function deletePost(int $postId): void;
}
