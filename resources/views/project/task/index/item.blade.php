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
    <td class="project-edit-hidden">
        <a href="#" class="edit-task-project" data-action="{{ route('tasks.edit', ['task' => $task]) }}" data-id="{{ $task->id }}"><i class="fa fa-edit fa-lg"></i></a>
        <a href="#" class="delete-task-project" data-token="{{ csrf_token() }}" data-action="{{ route('tasks.destroy', ['task' => $task]) }}"><i class="fa fa-trash fa-lg"></i></a>
    </td>
</tr>