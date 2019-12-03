@if ($schedules->isNotEmpty())
    <table class="table">
        <thead>
            <tr>
                <th>Choose</th>
                <th>Title</th>
                <th>Description</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @each('project.schedule.index.select', $schedules, 'schedule')
        </tbody>
    </table>
@else
    <p class="text-center">
        No results found.
    </p>
@endif