<table class="table">
    <tbody>
        @if ($tasks && $tasks->isNotEmpty())
            @each('project.schedule-task.index.item', $tasks, 'task')
        @endif
    </tbody>
</table>