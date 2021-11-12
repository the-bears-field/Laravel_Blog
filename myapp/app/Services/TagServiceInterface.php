<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface TagServiceInterface
{
    public function getAll(): Collection;
    public function getTag(string $tagName);
}