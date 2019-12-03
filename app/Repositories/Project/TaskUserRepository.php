<?php

namespace App\Repositories\Project;

use App\Models\Project\TaskUser;

class TaskUserRepository
{

    public function attachUsersForTask($taskId, $attachs)
    {
        TaskUser::where('task_id', $taskId)->delete();

        foreach ($attachs as $attach) {
            TaskUser::create([
                'task_id' => $taskId,
                'user_id' => $attach,
            ]);
        }

        return true;
    }
}