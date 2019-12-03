<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Project\ScheduleTask;
use App\Models\Project\TaskType;

class NameScheduleTaskUpdating
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ScheduleTask $task)
    {
        $originalTypeId = $task->getOriginal('task_type_id');

        if ($originalTypeId == $task->task_type_id) return;

        $taskType = TaskType::where('id', $task->task_type_id)->first();

        if ($taskType) {
            $task->name = $taskType->name;
        } 
    }
}
