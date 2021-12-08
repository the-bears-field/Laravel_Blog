<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PostRepositoryInterface
{
    public function getAll(): LengthAwarePaginator;
    public function getPost(int $postId);
    public function getPostsWithSearchWords(array $searchWords): LengthAwarePaginator;
    public function getPostsWithSearchTag(string $searchTag): LengthAwarePaginator;
    public function getPostsRelatedUser(User $user): Collection;
    public function createPost(CreateRequest $request): Post;
    public function updatePost(UpdateRequest $request): void;
    public function deletePost(int $postId): void;
    public function deletePosts(array $postIds): void;
}