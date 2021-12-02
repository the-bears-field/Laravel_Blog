<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\User\DeleteRequest;
use App\Http\Requests\User\UpdateNameRequest;
use App\Http\Requests\User\UpdateEmailRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
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

    public function updateName(UpdateNameRequest $request)
    {
        $this->userService->updateUser($request);
        return redirect('/user');
    }

    public function editEmail(Request $request): View
    {
        return view('user.email');
    }

    public function updateEmail(UpdateEmailRequest $request)
    {
        $this->userService->updateUser($request);
        return redirect('/user');
    }

    public function editPassword(Request $request): View
    {
        return view('user.password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->userService->updateUser($request);
        return redirect('/user');
    }

    public function delete()
    {
        return view('user.delete');
    }

    public function destroy(DeleteRequest $request)
    {
        $this->userService->deleteUser();
        return redirect('/');
    }
}
