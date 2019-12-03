<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use App\Models\User\Order;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\ProjectService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\User\CustomerCreateRequest;
use App\Http\Requests\User\CustomerUpdateRequest;

class CustomerController extends Controller
{
    private $userService;

    private $projectService;

    public function __construct(UserService $userService, ProjectService $projectService)
    {
        $this->userService = $userService;
        $this->projectService = $projectService;
    }

    public function index()
    {
        return view('user.customer.index', [
            'users' => $this->userService->getCustomersPaginate()
        ]);
    }

    public function create() {
        return view('user.customer.create', [
            'listSources' => $this->userService->pluckListSources(),
            'listProjectType' => $this->projectService->pluckListTypes(),
            'listStatus' => Order::getStatuses(),
            'listProjectManager' => $this->userService->listProjectManager(),
            'project_manager_id' => Auth::id()
        ]);
    }

    public function store(CustomerCreateRequest $request)
    {
        DB::beginTransaction();

        if (($user = $this->userService->createNewCustomer($request->all()))) {
            DB::commit();

            return redirect()->route('customers.show', $user);
        }

        DB::rollBack();

        return redirect()->route('customers.create');
    }

    public function show($userId) {

        return view('user.customer.show', [
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

        return view('user.customer.edit', [
            'user' => $user,
            'profile' => $user->profile,
            'order' => $user->orders->first(),
            'listSources' => $this->userService->pluckListSources(),
            'listProjectType' => $this->projectService->pluckListTypes(),
            'listStatus' => Order::getStatuses(),
            'listProjectManager' => $this->userService->listProjectManager()
        ]);
    }

    public function update(CustomerUpdateRequest $request, $userId) {
        $user = User::findOrFail($userId);

        $this->userService->updateCustomer($user, $request->all());

        return redirect()->route('customers.show', $user);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect(route('customers.index'));
    }

    public function getInfoUserProject(User $user) {
        if (!$user->profile) {
            return response()->json([
                'status' => 'error',
            ]);    
        }

        $orderData = null;
        if (($order = $user->order)) {
            $orderData = $order->only([
                'project_type_id',
                'project_manager_id',
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'user' => $user->profile->only([
                'city',
                'postal_code',
                'state',
                'street_address1',
                'street_address2',
            ]),
            'order' => $orderData,
        ]);
    }
}