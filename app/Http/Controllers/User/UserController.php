<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use App\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('user.user.index', [
            'users' => $this->userService->getUsersNotRolePaginate()
        ]);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect(route('users.index'));
    }

    public function sendNewAccesses(User $user) {
        $result = $this->userService->sendNewAccesses($user);

        return response()->json([
            'status' => $result?'ok':'error',
        ]);
    }
}