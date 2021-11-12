<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Services\TagServiceInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private TagServiceInterface $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index(string $tagName): View
    {
        $tags    = $this->tagService->getAll();
        $tag     = $this->tagService->getTag($tagName);
        return view('tag.index', compact('tags', 'tag', 'tagName'));
    }
}
