<?php

namespace App\Http\Controllers\Setting;

use App\Models\Project\Type;
use App\Http\Controllers\Controller;
use App\Services\ProjectTypeService;
use App\Http\Requests\ProjectType\ProjectTypeCreateRequest;
use App\Http\Requests\ProjectType\ProjectTypeUpdateRequest;

class ProjectTypeController extends Controller
{

    private $projectTypeService;

    public function __construct(ProjectTypeService $projectTypeService)
    {
        $this->projectTypeService = $projectTypeService;
    }

    public function index()
    {
        return view('setting.project-type.index', [
            'types' => $this->projectTypeService->getTypesPaginate()
        ]);
    }

    public function create() {
        return view('setting.project-type.create');
    }

    public function store(ProjectTypeCreateRequest $request)
    {
        $type = $this->projectTypeService->createNewType($request->all());
        return redirect()->route('project-types.show', $type);
    }

    public function show($typeId) {
        return view('setting.project-type.show', [
            'type' => Type::findOrFail($typeId)
        ]);
    }

    public function edit($typeId) {
        return view('setting.project-type.edit', [
            'type' => Type::findOrFail($typeId),
        ]);
    }

    public function update(ProjectTypeUpdateRequest $request, $typeId) {
        $type = Type::findOrFail($typeId);

        $this->projectTypeService->updateType($type, $request->all());

        return redirect()->route('project-types.show', $type);
    }

    public function destroy($id)
    {
        Type::destroy($id);
        return redirect(route('project-types.index'));
    }

    public function addQuick(ProjectTypeCreateRequest $request) {
        $type = $this->projectTypeService->createNewType($request->all());

        return response()->json([
            'status' => 'ok',
            'type' => $type
        ]);
    }
}