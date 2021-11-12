<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagRepository implements TagRepositoryInterface
{
    public function getAll(): Collection
    {
        return Tag::with('posts')->oldest('id')->get();
    }

    public function getTag(string $tagName)
    {
        return Tag::with('posts')->where('name', $tagName)->first();
    }

    public function createTag(string $string): Tag
    {
        return Tag::create(['name' => $string]);
    }

    public function getAvailableTagNames(): array
    {
        return Tag::pluck('name', 'id')->toArray();
    }

    public function deleteTag(string $string): void
    {
        Tag::where('name', $string)->delete();
    }
}