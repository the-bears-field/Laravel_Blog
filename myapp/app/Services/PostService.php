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

    public function getPostForForm(int $postId)
    {
        $post = $this->postRepository->getPost($postId);

        if(isset($post->tags)){
            $post->tags = implode(' ', $post->tags->pluck('name')->toArray());
        }

        return $post;
    }

    public function createPost($request): void
    {
        $post = $this->postRepository->createPost($request);
        $user = Auth::user();
        $user->posts()->syncWithoutDetaching(intval($post->id));

        if(!$request->tags){
            return;
        }

        $sentTagNames      = $this->stringToArray($request->tags);
        $availableTagNames = $this->tagRepository->getAvailableTagNames();

        foreach($sentTagNames as $tagName){
            $isExistTag =  in_array($tagName, $availableTagNames, true);

            if(!$isExistTag) {
                $insertedTag        = $this->tagRepository->createTag($tagName);
                $availableTagNames += [$insertedTag->id => $insertedTag->name];
            }

            $attachTagIds[] = array_search($tagName, $availableTagNames, true);
        }

        $post->tags()->syncWithoutDetaching($attachTagIds);
    }

    /**
     * スペースで区切った文字列を配列に変換。
     *
     * @return array
     */
    private function stringToArray (string $string): array
    {
        // 全角スペースを半角へ
        $string = preg_replace('/(\xE3\x80\x80)/', ' ', $string);
        // 両サイドのスペースを消す
        $string = trim($string);
        // 改行、タブをスペースに変換
        $string = preg_replace('/[\n\r\t]/', ' ', $string);
        // 複数スペースを一つのスペースに変換
        $string = preg_replace('/\s{2,}/', ' ', $string);
        //文字列を配列に変換
        $array = preg_split('/[\s]/', $string, -1, PREG_SPLIT_NO_EMPTY);
        $array = array_unique($array);
        $array = array_values($array);
        return $array;
    }
}
