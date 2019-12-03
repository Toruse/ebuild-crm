@if ($project)
    <strong>Contract Price:</strong> @if ($project->price)${{ $project->price }}@endif<br>
    @if ($project->projectType) <strong>Remodel Type:</strong> {{ $project->projectType->name }}<br>@endif
    <strong>Address Street 1:</strong> {{ $project->street_address1 }}<br>
    <strong>Address Street 2:</strong> {{ $project->street_address2 }}<br>
    <strong>City:</strong> {{ $project->city }}<br>
    <strong>State:</strong> {{ $project->state }}<br>
    <strong>Zip:</strong> {{ $project->postal_code }}<br>
    @if ($project->projectManager) <strong>Project Manager:</strong> {{ $project->projectManager->full_name }}<br>@endif
    <strong>Start Date:</strong> {{ $project->user_start_date }}<br>
    <strong>End Date:</strong> {{ $project->user_end_date }}<br>
@endif