@if ($tasks && $tasks->isNotEmpty())
    @each('project.task.index.item', $tasks, 'task')
@endif