<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function updateUser($request): void;
    public function deleteUser(int $userId): void;
}