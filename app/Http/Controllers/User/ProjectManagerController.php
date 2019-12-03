<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use App\Models\User\Order;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProjectManagerCreateRequest;
use App\Http\Requests\User\ProjectManagerUpdateRequest;

class ProjectManagerController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('user.project-manager.index', [
            'users' => $this->userService->getProjectManagersPaginate()
        ]);
    }

    public function create() {
        return view('user.project-manager.create', [
            'listActive' => Order::getListActive(),
        ]);
    }

    public function store(ProjectManagerCreateRequest $request)
    {
        DB::beginTransaction();

        if (($user = $this->userService->createNewProjectManager($request->all()))) {
            DB::commit();

            return redirect()->route('project-managers.show', $user);
        }

        DB::rollBack();

        return redirect()->route('project-managers.create');
    }

    public function show($userId) {

        return view('user.project-manager.show', [
            'user' => User::findOrFail($userId)
        ]);
    }

    public function edit($userId) {
        $user = User::findOrFail($userId);

        if (!$user->profile) {
            $this->userService->createNewEmptyProfile($user);
        }

        if ($user->orders->isEmpty()) {
            $this->userService->createNewEmptyOrder($user);
        }

        return view('user.project-manager.edit', [
            'user' => $user,
            'profile' => $user->profile,
            'order' => $user->orders->first(),
            'listActive' => Order::getListActive(),
        ]);
    }

    public function update(ProjectManagerUpdateRequest $request, $userId) {
        $user = User::findOrFail($userId);

        $this->userService->updateProjectManager($user, $request->all());

        return redirect()->route('project-managers.show', $user);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect(route('project-managers.index'));
    }
}