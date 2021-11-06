<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\PostRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface PostServiceInterface
{
    public function getAll(): Collection;
    public function getPost(int $postId);
    public function getPostForForm(int $postId);
    public function createPost($request): void;
    public function updatePost(PostRequest $request): void;
    public function deletePost(Request $request): void;
}
