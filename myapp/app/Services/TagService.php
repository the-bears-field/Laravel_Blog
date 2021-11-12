<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TagService implements TagServiceInterface
{
    private TagRepositoryInterface $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAll(): Collection
    {
        return $this->tagRepository->getAll();
    }

    public function getTag(string $tagName)
    {
        $tag = $this->tagRepository->getTag($tagName);

        if($tag && $tag->posts->isNotEmpty()){
            $tag->posts = $tag->posts->sortByDesc('updated_at');
        }

        return $tag;
    }
}