<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

interface TagRepositoryInterface
{
    public function getAll(): Collection;
    public function createTag(string $string): Tag;
    public function getAvailableTagNames(): array;
    public function deleteTag(string $string): void;
}