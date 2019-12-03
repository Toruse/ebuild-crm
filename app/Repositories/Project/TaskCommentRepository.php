<?php

namespace App\Repositories\Project;

use App\Models\Project\Task;
use Illuminate\Support\Facades\Auth;

class TaskCommentRepository
{
    public function createComment(Task $task, $note)
    {
        return $task->comments()->create([
            'user_id' => Auth::user()->id,
            'comment' => $note,
        ]);
    }
}