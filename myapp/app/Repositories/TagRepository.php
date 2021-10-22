<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tag;

class TagRepository implements TagRepositoryInterface
{
    public function createTag(string $string): Tag
    {
        return Tag::create(['name' => $string]);
    }

    public function getAvailableTagNames(): array
    {
        return Tag::pluck('name', 'id')->toArray();
    }
}