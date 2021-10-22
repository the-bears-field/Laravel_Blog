<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\PostRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PostService implements PostServiceInterface
{
    private PostRepositoryInterface $postRepository;
    private TagRepositoryInterface  $tagRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        PostRepositoryInterface $postRepository,
        TagRepositoryInterface  $tagRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->tagRepository  = $tagRepository;
        $this->userRepository = $userRepository;
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
