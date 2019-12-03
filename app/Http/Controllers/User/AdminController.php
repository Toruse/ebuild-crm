<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AdminCreateRequest;
use App\Http\Requests\User\AdminUpdateRequest;

class AdminController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('user.admin.index', [
            'users' => $this->userService->getAdminsPaginate()
        ]);
    }

    public function create() {
        return view('user.admin.create');
    }

    public function store(AdminCreateRequest $request)
    {
        DB::beginTransaction();

        if (($user = $this->userService->createNewAdmin($request->all()))) {
            DB::commit();

            return redirect()->route('admins.show', $user);
        }

        DB::rollBack();

        return redirect()->route('admins.create');
    }

    public function show($userId) {

        return view('user.admin.show', [
            'user' => User::findOrFail($userId)
        ]);
    }

    public function edit($userId) {
        $user = User::findOrFail($userId);

        return view('user.admin.edit', [
            'user' => $user,
        ]);
    }

    public function update(AdminUpdateRequest $request, $userId) {
        $user = User::findOrFail($userId);

        $this->userService->updateAdmin($user, $request->all());

        return redirect()->route('admins.show', $user);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect(route('admins.index'));
    }
}