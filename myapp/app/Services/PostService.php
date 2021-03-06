<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function getAll(): LengthAwarePaginator
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

    public function getPostsWithSearchWords(string $searchWords): LengthAwarePaginator
    {
        $searchWords = $this->stringToArray($searchWords);
        return $this->postRepository->getPostsWithSearchWords($searchWords);
    }

    public function getPostsWithSearchTag(string $searchTag): LengthAwarePaginator
    {
        return $this->postRepository->getPostsWithSearchTag($searchTag);
    }

    public function createPost(CreateRequest $request): void
    {
        $post = $this->postRepository->createPost($request);
        $user = Auth::user();
        $user->posts()->syncWithoutDetaching(intval($post->id));

        if($request->tags){
            $sentTagNames = $this->stringToArray($request->tags);
            $this->tagRegistAndSync($post, $sentTagNames);
        }
    }

    public function updatePost(UpdateRequest $request): void
    {
        $this->postRepository->updatePost($request);

        if(!$request->tags){
            return;
        }

        $postId          = intval($request->postId);
        $post            = $this->postRepository->getPost($postId);
        $sentTagNames    = $this->stringToArray($request->tags);
        $currentTagNames = $post->tags->pluck('name')->toArray();
        $addTagNames     = array_diff($sentTagNames, $currentTagNames);
        $removeTagNames  = array_diff($currentTagNames, $sentTagNames);
        $this->tagRegistAndSync($post, $addTagNames);
        $this->tagDeleteAndDetach($post, $removeTagNames);
    }

    public function deletePost(int $postId): void
    {
        $post = $this->postRepository->getPost($postId);

        if($post->tags->isNotEmpty()){
            $removeTagNames = $post->tags->pluck('name')->toArray();
            $this->tagDeleteAndDetach($post, $removeTagNames);
        }

        $post->users()->detach(Auth::id());

        $this->postRepository->deletePost($postId);
    }

    private function tagRegistAndSync(Post $post, array $tagNames)
    {
        $availableTagNames = $this->tagRepository->getAvailableTagNames();
        $attachTagIds      = [];

        foreach($tagNames as $tagName){
            $isExistTag = in_array($tagName, $availableTagNames, true);

            if(!$isExistTag) {
                $insertedTag        = $this->tagRepository->createTag($tagName);
                $availableTagNames += [$insertedTag->id => $insertedTag->name];
            }

            $attachTagIds[] = array_search($tagName, $availableTagNames, true);
        }

        if($attachTagIds){
            $post->tags()->syncWithoutDetaching($attachTagIds);
        }
    }

    private function tagDeleteAndDetach(Post $post, array $tagNames)
    {
        $detachTagIds = [];
        // ???????????????????????????
        foreach($post->tags as $tag){
            if(in_array($tag->name, $tagNames)){
                $detachTagIds[] = $tag->id;
            }
        }

        if($detachTagIds){
            $post->tags()->detach($detachTagIds);
        }

        // posts??????????????????????????????????????????tags???????????????????????????
        $availableTags = $this->tagRepository->getAll();

        foreach($availableTags as $tag){
            if($tag->posts->isEmpty()){
                $this->tagRepository->deleteTag($tag->name);
            }
        }
    }

    /**
     * ?????????????????????????????????????????????????????????
     *
     * @return array
     */
    private function stringToArray (string $string): array
    {
        // ??????????????????????????????
        $string = preg_replace('/(\xE3\x80\x80)/', ' ', $string);
        // ????????????????????????????????????
        $string = trim($string);
        // ???????????????????????????????????????
        $string = preg_replace('/[\n\r\t]/', ' ', $string);
        // ???????????????????????????????????????????????????
        $string = preg_replace('/\s{2,}/', ' ', $string);
        //???????????????????????????
        $array = preg_split('/[\s]/', $string, -1, PREG_SPLIT_NO_EMPTY);
        $array = array_unique($array);
        $array = array_values($array);
        return $array;
    }
}
