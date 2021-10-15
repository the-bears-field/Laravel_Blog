<?php
declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    public function getAll(): Collection;
    public function getPost(int $postId);
}