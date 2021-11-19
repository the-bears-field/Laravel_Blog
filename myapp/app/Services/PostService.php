<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\PostRequest;
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

    public function createPost($request): void
    {
        $purifiedRequest = $this->getPurifiedRequest($request);
        $post = $this->postRepository->createPost($purifiedRequest);
        $user = Auth::user();
        $user->posts()->syncWithoutDetaching(intval($post->id));

        if($request->tags){
            $sentTagNames = $this->stringToArray($purifiedRequest->tags);
            $this->tagRegistAndSync($post, $sentTagNames);
        }
    }

    public function updatePost(PostRequest $request): void
    {
        $purifiedRequest = $this->getPurifiedRequest($request);
        $this->postRepository->updatePost($purifiedRequest);

        if(!$purifiedRequest->tags){
            return;
        }

        $postId          = intval($purifiedRequest->postId);
        $post            = $this->postRepository->getPost($postId);
        $sentTagNames    = $this->stringToArray($purifiedRequest->tags);
        $currentTagNames = $post->tags->pluck('name')->toArray();
        $addTagNames     = array_diff($sentTagNames, $currentTagNames);
        $removeTagNames  = array_diff($currentTagNames, $sentTagNames);
        $this->tagRegistAndSync($post, $addTagNames);
        $this->tagDeleteAndDetach($post, $removeTagNames);
    }

    public function deletePost(Request $request): void
    {
        $postId = intval($request->postId);
        $post   = $this->postRepository->getPost($postId);

        if($post->tags->isNotEmpty()){
            $removeTagNames = $post->tags->pluck('name')->toArray();
            $this->tagDeleteAndDetach($post, $removeTagNames);
        }

        $post->users()->detach(Auth::id());

        $this->postRepository->deletePost($request);
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
        // 紐付け解除の処理。
        foreach($post->tags as $tag){
            if(in_array($tag->name, $tagNames)){
                $detachTagIds[] = $tag->id;
            }
        }

        if($detachTagIds){
            $post->tags()->detach($detachTagIds);
        }

        // postsテーブルと紐付けされていないtagsのレコードを削除。
        $availableTags = $this->tagRepository->getAll();

        foreach($availableTags as $tag){
            if($tag->posts->isEmpty()){
                $this->tagRepository->deleteTag($tag->name);
            }
        }
    }

    private function getPurifiedRequest($request)
    {
        return $request->merge(['post' => clean($request->post)]);
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
