<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function updateUser($request): void
    {
        $this->userRepository->updateUser($request);
    }
}