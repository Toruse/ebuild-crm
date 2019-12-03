<?php

namespace App\Services;

use App\Models\Project\Project;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Project\PublishNotification;

class NotificationProjectService
{
    public function publishProject(Project $project)
    {
        if (!$project->publish) return;
        $users = collect();

        $user = Auth::user();

        if ($project->customer) {
            $users->push($project->customer);
        }
        if ($project->projectManager) {
            $users->push($project->projectManager);
        }
        if ($project->tasks) {
            foreach ($project->tasks as $task) {
                $users = collect($users)->merge($task->bindUsers)->all();
            }
        }
        
        $users = collect($users)
            ->unique('id')
            ->values()
            ->all();
        
        foreach ($users as $user) {
            $user->notify(new PublishNotification($project));
        }
    }
}