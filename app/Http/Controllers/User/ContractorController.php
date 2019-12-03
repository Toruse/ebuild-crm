<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use App\Models\User\Order;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\ProjectService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ContractorCreateRequest;
use App\Http\Requests\User\ContractorUpdateRequest;

class ContractorController extends Controller
{
    private $userService;

    /**
     * Undocumented variable
     *
     * @var ProjectService
     */
    private $projectService;

    public function __construct(UserService $userService, ProjectService $projectService)
    {
        $this->userService = $userService;
        $this->projectService = $projectService;
    }

    public function index()
    {
        return view('user.contractor.index', [
            'users' => $this->userService->getContractorsPaginate()
        ]);
    }

    public function create() {
        return view('user.contractor.create', [
            'listStatus' => Order::getStatuses(),
            'listSkillSpecialty' => $this->projectService->pluckListSkillSpecialty()
        ]);
    }

    public function store(ContractorCreateRequest $request)
    {
        DB::beginTransaction();

        if (($user = $this->userService->createNewContractor($request->all()))) {
            DB::commit();

            return redirect()->route('contractors.show', $user);
        }

        DB::rollBack();

        return redirect()->route('contractors.create');
    }

    public function show($userId) {

        return view('user.contractor.show', [
            'user' => User::findOrFail($userId)
        ]);
    }

    public function edit($userId) {
        $user = User::findOrFail($userId);

        if (!$user->profile) {
            $this->userService->createNewEmptyProfile($user);
        }

        return view('user.contractor.edit', [
            'user' => $user,
            'profile' => $user->profile,
            'order' => $user->orders->first(),
            'listStatus' => Order::getStatuses(),
            'listSkillSpecialty' => $this->projectService->pluckListSkillSpecialty()
        ]);
    }

    public function update(ContractorUpdateRequest $request, $userId) {
        $user = User::findOrFail($userId);

        $this->userService->updateContractor($user, $request->all());

        return redirect()->route('contractors.show', $user);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect(route('contractors.index'));
    }
}