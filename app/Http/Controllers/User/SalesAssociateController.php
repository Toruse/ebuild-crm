<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use App\Models\User\Order;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SalesAssociateCreateRequest;
use App\Http\Requests\User\SalesAssociateUpdateRequest;

class SalesAssociateController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('user.sales-associate.index', [
            'users' => $this->userService->getSalesAssociatesPaginate()
        ]);
    }

    public function create() {
        return view('user.sales-associate.create', [
            'listActive' => Order::getListActive(),
        ]);
    }

    public function store(SalesAssociateCreateRequest $request)
    {
        DB::beginTransaction();

        if (($user = $this->userService->createNewSalesAssociate($request->all()))) {
            DB::commit();

            return redirect()->route('sales-associates.show', $user);
        }

        DB::rollBack();

        return redirect()->route('sales-associates.create');
    }

    public function show($userId) {

        return view('user.sales-associate.show', [
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

        return view('user.sales-associate.edit', [
            'user' => $user,
            'profile' => $user->profile,
            'order' => $user->orders->first(),
            'listActive' => Order::getListActive(),
        ]);
    }

    public function update(SalesAssociateUpdateRequest $request, $userId) {
        $user = User::findOrFail($userId);

        $this->userService->updateSalesAssociate($user, $request->all());

        return redirect()->route('sales-associates.show', $user);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect(route('sales-associates.index'));
    }
}