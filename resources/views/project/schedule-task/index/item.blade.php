<tr>
    <td>
        {!! Form::hidden('task_ids[]', $task->id) !!}
        <span class="color-view" style="background-color: {{ $task->color }}"></span>
        {{ $task->name_type }}
    </td>
    <td>
        {{ $task->user_start_date }}
    </td>
    <td>
        {{ $task->user_end_date }}
    </td>
    <td>
        <a href="#" class="edit-task-schedule" data-action="{{ route('schedule-tasks.edit', ['scheduleTask' => $task]) }}" data-id="{{ $task->id }}"><i class="fa fa-edit fa-lg"></i></a>
        <a href="#" class="delete-task-schedule" data-token="{{ csrf_token() }}" data-action="{{ route('schedule-tasks.destroy', ['scheduleTask' => $task]) }}"><i class="fa fa-trash fa-lg"></i></a>
    </td>
</tr>