<?php

namespace App\Repositories\Project;

use App\Models\Project\ScheduleTaskUser;

class ScheduleTaskUserRepository
{

    public function attachUsersForTask($taskId, $attachs)
    {
        ScheduleTaskUser::where('task_id', $taskId)->delete();

        foreach ($attachs as $attach) {
            ScheduleTaskUser::create([
                'task_id' => $taskId,
                'user_id' => $attach,
            ]);
        }

        return true;
    }
}