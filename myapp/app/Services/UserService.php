<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceInterface
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

    public function updateUser($request): void
    {
        $this->userRepository->updateUser($request);
    }

    public function deleteUser(): void
    {
        $posts         = $this->postRepository->getPostsRelatedUser(Auth::user());
        $userId        = Auth::id();
        $deletePostIds = [];

        foreach($posts as $post){
            $this->tagDetach($post);
            $post->users()->detach($userId);
            $deletePostIds[] = $post->id;
        }

        $this->tagDelete();

        if($deletePostIds){
            $this->postRepository->deletePosts($deletePostIds);
        }

        $this->userRepository->deleteUser($userId);
    }

    private function tagDetach(Post $post): void
    {
        $detachTagIds = [];

        foreach($post->tags as $tag){
            $detachTagIds[] = $tag->id;
        }

        if($detachTagIds){
            $post->tags()->detach($detachTagIds);
        }
    }

    private function tagDelete(): void
    {
        $availableTags = $this->tagRepository->getAll();

        foreach($availableTags as $tag){
            if($tag->posts->isEmpty()){
                $this->tagRepository->deleteTag($tag->name);
            }
        }
    }
}
