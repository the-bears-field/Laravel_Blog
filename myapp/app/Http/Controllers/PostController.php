<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostServiceInterface;
use App\Services\TagServiceInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private PostServiceInterface $postService;
    private TagServiceInterface  $tagService;

    public function __construct(
        PostServiceInterface $postService,
        TagServiceInterface  $tagService
    )
    {
        $this->postService = $postService;
        $this->tagService  = $tagService;
    }

    public function index(Request $request): View
    {
        $posts = $this->postService->getAll();
        $tags  = $this->tagService->getAll();
        return view('post.index', compact('posts', 'tags'));
    }

    public function show(Request $request)
    {
        $postId = intval($request->postId);
        $post   = $this->postService->getPost($postId);
        $tags   = $this->tagService->getAll();
        return $post ? view('post.show', compact('post', 'tags')) : redirect('/');
    }

    public function search(Request $request): View
    {
        $searchWord = $request->searchWord;
        $posts = $this->postService->getPostsWithSearchWords($searchWord);
        $tags  = $this->tagService->getAll();
        return view('post.search', compact('posts', 'tags', 'searchWord'));
    }

    public function searchTag(string $tagName): View
    {
        $posts = $this->postService->getPostsWithSearchTag($tagName);
        $tags  = $this->tagService->getAll();
        return view('post.searchTag', compact('tags', 'posts', 'tagName'));
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
        $postId = intval($request->postId);
        $post = $this->postService->getPost($postId);
        $this->authorize('update', $post);
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
        $postId = intval($request->postId);
        $post = $this->postService->getPost($postId);
        $this->authorize('delete', $post);
        $this->postService->deletePost($request);
        return redirect('/');
    }
}
