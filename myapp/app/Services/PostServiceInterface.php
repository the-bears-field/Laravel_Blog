<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\PostRequest;
use Illuminate\Database\Eloquent\Collection;

interface PostServiceInterface
{
    public function getAll(): Collection;
    public function getPost(int $postId);
    public function getPostForForm(int $postId);
    public function createPost($request): void;
    public function updatePost(PostRequest $request): void;
}
