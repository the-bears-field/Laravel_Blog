<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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

    public function getPostsRelatedUser(User $user): Collection
    {
        return Post::with('users')
                ->with('tags')
                ->whereHas('users', function (Builder $query) use ($user) {
                    $query->where('email', $user->email);
                })
                ->get();
    }

    public function createPost(CreateRequest $request): Post
    {
        $params = $request->only(['title', 'post']);
        return Post::create($params);
    }

    public function updatePost(UpdateRequest $request): void
    {
        $params = $request->only(['title', 'post']);
        Post::where('id', intval($request->postId))->update($params);
    }

    public function deletePost(int $postId): void
    {
        Post::where('id', $postId)->delete();
    }

    public function deletePosts(array $postIds): void
    {
        Post::whereIn('id', $postIds)->delete();
    }
}
