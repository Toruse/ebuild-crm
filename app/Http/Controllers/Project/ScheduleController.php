<?php

namespace App\Http\Controllers\Project;

use App\Services\UserService;
use App\Models\Project\Schedule;
use App\Models\Project\Project;
use App\Services\ScheduleService;
use App\Services\TaskService;
use App\Services\TaskTypeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\ScheduleCreateRequest;
use App\Http\Requests\Schedule\ScheduleSelectRequest;
use App\Http\Requests\Schedule\ScheduleUpdateRequest;

class ScheduleController extends Controller
{
    private $scheduleService;
    private $userService;

    public function __construct(ScheduleService $scheduleService, UserService $userService)
    {
        $this->scheduleService = $scheduleService;
        $this->userService = $userService;
    }

    public function index()
    {        
        return view('project.schedule.index'.$this->scheduleService->getRequestModal(), [
            'schedules' => $this->scheduleService->getSchedulesPaginate(),
            'modal' => request()->input('modal'),
        ]);
    }

    public function store(ScheduleCreateRequest $request)
    {
        $schedule = $this->scheduleService->createNewSchedule($request->all());
        return response()->json([
            'status' => 'ok',
            'route' => route('schedules.edit', [
                'schedule' => $schedule,
                'modal' => request()->input('modal')
            ])
        ]);
    }

    public function edit(Schedule $schedule) {
        return view('project.schedule.edit'.$this->scheduleService->getRequestModal(), [
            'schedule' => $schedule,
            'tasks' => $schedule->tasks,
            'schedule_id' => $schedule->id,
            'listBindUsers' =>  $this->userService->mapListBindUsers(),
            'listTaskTypes' => TaskTypeService::pluckListTaskTypes(),
            'modal' => request()->input('modal'),
            'defaultDate' => $this->scheduleService->getFirstDateTask($schedule),
        ]);
    }

    public function update(ScheduleUpdateRequest $request, Schedule $schedule) {
        $this->scheduleService->updateSchedule($schedule, $request->all());

        $modal = request()->input('modal');

        if ($modal && !$request->ajax()) {
            return redirect()->route('schedules.index', [$schedule, 'modal' => $modal]);
        }

        switch ($modal) {
            case '1':
                return response()->json([
                    'status' => 'ok',
                ]);
            case '2':
                return response()->json([
                    'status' => 'ok',
                ]);
            default:
                return redirect()->route('schedules.show', [$schedule, 'modal' => $modal]);
        }
    }

    public function show($scheduleId) {
        return view('project.schedule.show'.$this->scheduleService->getRequestModal(), [
            'schedule' => Schedule::findOrFail($scheduleId),
            'modal' => request()->input('modal'),
        ]);
    }

    public function destroy($id)
    {
        Schedule::destroy($id);

        $modal = request()->input('modal');

        switch ($modal) {
            case '2':
                return redirect(route('schedules.close', ['modal' => $modal]));
            default:
                return redirect(route('schedules.index', ['modal' => $modal]));
        }
    }

    public function select(ScheduleSelectRequest $request)
    {
        $project = Project::find($request->input('project'));

        if ($project->publish) {
            return response()->json([
                'status' => 'error',
            ]);    
        }
        
        $tasks = $this->scheduleService->getListAddTask($request->all());
        return response()->json([
            'status' => 'ok',
            'htmlListNewTask' => view('project.task.index-group', [
                'tasks' => $tasks
            ])->render(),
            'htmlInfoProject' => view('project.project.info', [
                'project' => $project
            ])->render(),
            'events' => TaskService::getDataEventsToCalendar($tasks)
        ]);
    }

    public function close()
    {        
        return view('project.schedule.close'.$this->scheduleService->getRequestModal(), [
            'modal' => request()->input('modal'),
        ]);
    }
}
