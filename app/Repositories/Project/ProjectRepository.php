<?php

namespace App\Repositories\Project;

use Carbon\Carbon;
use App\Models\Project\Task;
use App\Models\Project\Project;
use App\Models\Project\Schedule;

class ProjectRepository
{
    public function getCurrentDateProjects()
    {
        return Project::with('customer')
            ->whereDate('end_date', '>=', Carbon::today())
            ->orWhereNull('end_date')
            ->get();
    }

    public function getUserCurrentProjects($userId)
    {
        return Project::with('customer')
            ->where(function($query) {
                $query->whereDate('end_date', '>=', Carbon::today());
                $query->orWhereNull('end_date');
            })
            ->whereCustomerId($userId)
            ->wherePublish(1)
            ->get();
    }

    public function getSchedules()
    {
        return Schedule::get();
    }

    public function createNewProject($fields)
    {
        return Project::create([
            'customer_id' => $fields['customer'],
            'price' => $fields['price'],
            'project_type_id' => $fields['type'],
            'street_address1' => $fields['street_address1'],
            'street_address2' => $fields['street_address2'],
            'city' => $fields['city'],
            'state' => $fields['state'],
            'postal_code' => $fields['postal_code'],
            'project_manager_id' => $fields['project_manager'],
            'color' => $fields['color'],
            'start_date' => (new Carbon($fields['start_date']))->format('Y-m-d'),
            'end_date' => (new Carbon($fields['end_date']))->format('Y-m-d'),
        ]);
    }

    public function updateProject(Project $project, $fields)
    {
        $project->customer_id = $fields['customer'];
        $project->price = $fields['price'];
        $project->project_type_id = $fields['type'];
        $project->street_address1 = $fields['street_address1'];
        $project->street_address2 = $fields['street_address2'];
        $project->city = $fields['city'];
        $project->state = $fields['state'];
        $project->postal_code = $fields['postal_code'];
        $project->project_manager_id = $fields['project_manager'];
        $project->color = $fields['color'];
        $project->user_start_date = $fields['start_date'];
        $project->user_end_date = $fields['end_date'];
        return $project->save();
    }

    public static function updateEndDate($projectId) {
        $project = Project::findOrFail($projectId);

        if ($project->end_date) {
            return;
        }

        $task = Task::where(['project_id' => $project->id])
            ->orderBy('end_date', 'desc')
            ->first();

        if ($task) {
            $project->end_date = $task->end_date;
            $project->save();
        }
    }

    public function getFormDataProject(Project $project) {
        $arrayProject = $project->toArray();

        $arrayProject['customer'] = $arrayProject['customer_id'];
        unset($arrayProject['customer_id']);
        $arrayProject['project_manager'] = $arrayProject['project_manager_id'];
        unset($arrayProject['project_manager_id']);

        $arrayProject['start_date'] = $project->user_start_date;
        $arrayProject['end_date'] = $project->user_end_date;

        return $arrayProject;
    }

    public function updateStartEndDateProject(Project $project, $fields)
    {
        $project->start_date = $fields['start_date'];
        $project->end_date = $fields['end_date'];
        return $project->save();
    }

    public function setPublishProject(Project $project, $fields) {
        $project->publish = $fields['publish'];
        return $project->save();
    }
}