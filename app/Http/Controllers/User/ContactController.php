<?php

namespace App\Http\Controllers\User;

use App\Models\User\Order;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\ProjectService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\MaterialServiceService;
use App\Http\Requests\User\CustomerCreateRequest;

class ContactController extends Controller
{
    private $userService;
    private $projectService;
    private $materialServicerService;

    public function __construct(UserService $userService, ProjectService $projectService, MaterialServiceService $materialServicerService)
    {
        $this->userService = $userService;
        $this->projectService = $projectService;
        $this->materialServicerService = $materialServicerService;
    }

    public function create() {
        return view('user.contact.create', [
            'listSources' => $this->userService->pluckListSources(),
            'listProjectType' => $this->projectService->pluckListTypes(),
            'listStatus' => Order::getStatuses(),
            'listActive' => Order::getListActive(),
            'listProjectManager' => $this->userService->listProjectManager(),
            'listSkillSpecialty' => $this->projectService->pluckListSkillSpecialty(),
            'listMaterialService' => $this->materialServicerService->pluckListMaterialService(),
            'project_manager_id' => Auth::id(),
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        if (($nameRoute = $this->userService->createNewContact($request))) {
            DB::commit();

            return redirect()->route($nameRoute.'.index');
        }

        DB::rollBack();

        return redirect()->route('contacts.create');
    }
}