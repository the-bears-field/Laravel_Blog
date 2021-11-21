<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    private const PER_PAGE = 10;

    public function getAll(): LengthAwarePaginator
    {
        $posts = Post::with('users')->with('tags')->orderByDesc('id')->paginate(self::PER_PAGE);
        return $posts;
    }

    public function getPost(int $postId)
    {
        $post = Post::with('users')->with('tags')->find($postId);
        return $post;
    }

    public function getPostsWithSearchWords(array $searchWords): LengthAwarePaginator
    {
        return Post::with('users')
                ->with('tags')
                ->where(function (Builder $query) use ($searchWords) {
                    foreach($searchWords as $word){
                        $query->where('post', 'LIKE', "%$word%");
                    }
                })
                ->orWhere(function (Builder $query) use ($searchWords) {
                    foreach($searchWords as $word){
                        $query->where('title', 'LIKE', "%$word%");
                    }
                })
                ->paginate(self::PER_PAGE);
    }

    public function getPostsWithSearchTag(string $searchTag): LengthAwarePaginator
    {
        return Post::with('users')
                ->with('tags')
                ->whereHas('tags', function (Builder $query) use ($searchTag) {
                    $query->where('name', $searchTag);
                })
                ->paginate(self::PER_PAGE);
    }

    public function createPost(PostRequest $request): Post
    {
        $params = $request->only(['title', 'post']);
        return Post::create($params);
    }

    public function updatePost(PostRequest $request): void
    {
        $params = $request->only(['title', 'post']);
        Post::where('id', intval($request->postId))->update($params);
    }

    public function deletePost(Request $request): void
    {
        Post::where('id', intval($request->postId))->delete();
    }
}
