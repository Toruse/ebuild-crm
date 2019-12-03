<?php

namespace App\Services;

use App\Models\Project\Task;
use Illuminate\Http\Request;
use App\Repositories\Project\TaskCommentRepository;

class TaskCommentService
{
    protected $taskCommentRepository;

    public function __construct(TaskCommentRepository $taskCommentRepository)
    {
        $this->taskCommentRepository = $taskCommentRepository;
    }

    public function addTasksTodayComments(Request $request) {
        if (isset($request['notes'])) {
            $notes = $request['notes'];
            $tasks = Task::whereIn('id', array_keys($notes))->get();
            foreach ($tasks as $task) {
                if ($notes[$task->id]) {
                    $this->taskCommentRepository->createComment($task, $notes[$task->id]);
                }
            }
        }
    }
}