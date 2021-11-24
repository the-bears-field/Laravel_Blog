<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function updateUser($request): void
    {
        $params = $request->only('name', 'email', 'password');
        Auth::user()->update($params);
    }
}