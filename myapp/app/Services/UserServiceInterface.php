<?php
declare(strict_types=1);

namespace App\Services;

interface UserServiceInterface
{
    public function updateUser($request): void;
    public function deleteUser(): void;
}
