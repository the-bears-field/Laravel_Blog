<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tag;

interface TagRepositoryInterface
{
    public function createTag(string $string): Tag;
    public function getAvailableTagNames(): array;
}