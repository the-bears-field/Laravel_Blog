<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserNameRequest;
use App\Services\UserServiceInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        return view('user.index', ['user' => $user]);
    }

    public function editName(Request $request): View
    {
        return view('user.name');
    }

    public function updateName(UpdateUserNameRequest $request)
    {
        $this->userService->updateUser($request);
        return redirect('/user');
    }
}
