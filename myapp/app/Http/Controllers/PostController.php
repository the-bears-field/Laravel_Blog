<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostServiceInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private PostServiceInterface $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request): View
    {
        $posts = $this->postService->getAll();
        return view('post.index', compact('posts'));
    }

    public function show(Request $request)
    {
        $postId = intval($request->postId);
        $post = $this->postService->getPost($postId);
        return $post ? view('post.show', compact('post')) : redirect('/');
    }

    public function new(): View
    {
        return view('post.new');
    }

    public function create(PostRequest $request)
    {
        $this->authorize('create', Post::class);
        $this->postService->createPost($request);
        return redirect('/');
    }

    public function edit(Request $request): View
    {
        $post = $this->postService->getPostForForm(intval($request->postId));
        $this->authorize('update', $post);
        return view('post.edit', compact('post'));
    }

    public function update(PostRequest $request)
    {
        $this->authorize('update', Post::class);
        $this->postService->updatePost($request);
        return redirect('/');
    }

    public function delete(Request $request): View
    {
        $postId = intval($request->postId);
        $post = $this->postService->getPost($postId);
        $this->authorize('view', $post);
        return view('post.delete', compact('post'));
    }

    public function destroy(Request $request)
    {
        $postId = $request->postId;
        $userId = Auth::id();
        $post = Post::with('users')->find($postId);
        if(!$post) return redirect('/');
        $user = $post->users->find($userId);

        if($user){
            $user->posts()->detach($postId);
            Post::find($postId)->delete();
        }

        return redirect('/');
    }
}
