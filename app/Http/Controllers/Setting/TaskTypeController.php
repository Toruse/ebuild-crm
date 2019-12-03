<?php

namespace App\Http\Controllers\Setting;

use App\Models\Project\TaskType;
use App\Http\Controllers\Controller;
use App\Services\TaskTypeService;
use App\Http\Requests\TaskType\TaskTypeCreateRequest;
use App\Http\Requests\TaskType\TaskTypeUpdateRequest;

class TaskTypeController extends Controller
{

    private $taskTypeService;

    public function __construct(TaskTypeService $taskTypeService)
    {
        $this->taskTypeService = $taskTypeService;
    }

    public function index()
    {
        return view('setting.task-type.index', [
            'types' => $this->taskTypeService->getTypesPaginate()
        ]);
    }

    public function create() {
        return view('setting.task-type.create');
    }

    public function store(TaskTypeCreateRequest $request)
    {
        $type = $this->taskTypeService->createNewType($request->all());
        return redirect()->route('task-types.show', $type);
    }

    public function show($typeId) {
        return view('setting.task-type.show', [
            'type' => TaskType::findOrFail($typeId)
        ]);
    }

    public function edit($typeId) {
        return view('setting.task-type.edit', [
            'type' => TaskType::findOrFail($typeId),
        ]);
    }

    public function update(TaskTypeUpdateRequest $request, $typeId) {
        $type = TaskType::findOrFail($typeId);

        $this->taskTypeService->updateType($type, $request->all());

        return redirect()->route('task-types.show', $type);
    }

    public function destroy($id)
    {
        TaskType::destroy($id);
        return redirect(route('task-types.index'));
    }

    public function addQuick(TaskTypeCreateRequest $request) {
        $type = $this->taskTypeService->createNewType($request->all());

        return response()->json([
            'status' => 'ok',
            'type' => $type
        ]);
    }
}