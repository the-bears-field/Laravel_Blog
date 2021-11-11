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
}