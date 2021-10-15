<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface PostServiceInterface
{
    public function getAll(): Collection;
    public function getPost(int $postId);
}
