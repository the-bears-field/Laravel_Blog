<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Collection;

class PostService implements PostServiceInterface
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAll(): Collection
    {
        return $this->postRepository->getAll();
    }

    public function getPost(int $postId)
    {
        return $this->postRepository->getPost($postId);
    }
}