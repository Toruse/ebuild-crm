<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\MaterialServiceService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\User\VendorCreateRequest;
use App\Http\Requests\User\VendorUpdateRequest;

class VendorController extends Controller
{
    private $userService;
    private $materialServicerService;

    public function __construct(UserService $userService, MaterialServiceService $materialServicerService)
    {
        $this->userService = $userService;
        $this->materialServicerService = $materialServicerService;
    }

    public function index()
    {
        return view('user.vendor.index', [
            'users' => $this->userService->getVendorsPaginate()
        ]);
    }

    public function create() {
        return view('user.vendor.create', [
            'listMaterialService' => $this->materialServicerService->pluckListMaterialService(),
        ]);
    }

    public function store(VendorCreateRequest $request)
    {
        DB::beginTransaction();

        if (($user = $this->userService->createNewVendor($request->all()))) {
            DB::commit();

            return redirect()->route('vendors.show', $user);
        }

        DB::rollBack();

        return redirect()->route('vendors.create');
    }

    public function show($userId) {
        return view('user.vendor.show', [
            'user' => User::findOrFail($userId)
        ]);
    }

    public function edit($userId) {
        $user = User::findOrFail($userId);

        if (!$user->profile) {
            $this->userService->createNewEmptyProfile($user);
        }

        return view('user.vendor.edit', [
            'user' => $user,
            'profile' => $user->profile,
            'listMaterialService' => $this->materialServicerService->pluckListMaterialService(),
        ]);
    }

    public function update(VendorUpdateRequest $request, $userId) {
        $user = User::findOrFail($userId);

        $this->userService->updateVendor($user, $request->all());

        return redirect()->route('vendors.show', $user);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect(route('vendors.index'));
    }
}