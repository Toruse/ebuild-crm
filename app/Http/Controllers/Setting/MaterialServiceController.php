<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\User\MaterialService;
use App\Services\MaterialServiceService;
use App\Http\Requests\MaterialService\MaterialServiceCreateRequest;
use App\Http\Requests\MaterialService\MaterialServiceUpdateRequest;

class MaterialServiceController extends Controller
{

    private $materialServiceService;

    public function __construct(MaterialServiceService $materialServiceService)
    {
        $this->materialServiceService = $materialServiceService;
    }

    public function index()
    {
        return view('setting.material-service.index', [
            'materialServices' => $this->materialServiceService->getMaterialServicesPaginate()
        ]);
    }

    public function create() {
        return view('setting.material-service.create');
    }

    public function store(MaterialServiceCreateRequest $request)
    {
        $materialService = $this->materialServiceService->createNewMaterialService($request->all());
        return redirect()->route('material-services.show', $materialService);
    }

    public function show($materialServiceId) {
        return view('setting.material-service.show', [
            'materialService' => MaterialService::findOrFail($materialServiceId)
        ]);
    }

    public function edit($materialServiceId) {
        return view('setting.material-service.edit', [
            'materialService' => MaterialService::findOrFail($materialServiceId),
        ]);
    }

    public function update(MaterialServiceUpdateRequest $request, $materialServiceId) {
        $materialService = MaterialService::findOrFail($materialServiceId);

        $this->materialServiceService->updateMaterialService($materialService, $request->all());

        return redirect()->route('material-services.show', $materialService);
    }

    public function destroy($id)
    {
        MaterialService::destroy($id);
        return redirect(route('material-services.index'));
    }

    public function addQuick(MaterialServiceCreateRequest $request) {
        $materialService = $this->materialServiceService->createNewMaterialService($request->all());

        return response()->json([
            'status' => 'ok',
            'materialService' => $materialService
        ]);
    }
}