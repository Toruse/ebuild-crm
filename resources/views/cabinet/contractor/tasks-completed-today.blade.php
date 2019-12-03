@if ($tasks && $tasks->isNotEmpty())
<div class="panel-group" id="accordionTasks" role="tablist" aria-multiselectable="true">
    @each('cabinet.contractor.tasks-completed-today.panel', $tasks, 'task')
</div>
@endif