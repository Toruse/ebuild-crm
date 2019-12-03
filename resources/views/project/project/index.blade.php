@extends('layouts.app')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <a class="btn btn-success btn-block btn-add-project" href="{{ route('projects.create') }}">Add Project</a>
            <br>
            @if ($projects->isNotEmpty())
                @each('project.project.index.item', $projects, 'project')
            @else
                <p class="text-center">
                    No results found.
                </p>
            @endif
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                    <div class="calendar">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-right">
                    <br>
                    <a class="btn btn-default" href="#" data-toggle="modal" data-target="#indexSchedule">View/Edit Schedule Templates</a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('project.schedule.form.modal.index')

@endsection

@section('javascript')
    <script>
        var events = [
            @if ($projects->isNotEmpty())
                @foreach($projects as $project)
                {
                    id: {{ $project->id }},
                    title: '{{ $project->customerFullName }}',
                    start: '{{ (new \Carbon\Carbon($project->start_date))->format('Y-m-d') }}',
                    end: '{{ $project->end_date_calendar }}',
                    url: '{{ route('projects.edit', ['project' => $project]) }}',
                    textColor: 'white',
                    color: '{{ $project->color }}',
                    data: {
                        urlEventDrop: '{{ route('projects.event-drop', ['project' => $project]) }}',
                        urlEventResize: '{{ route('projects.event-resize', ['project' => $project]) }}',
                    }
                },
                @endforeach
            @endif
        ];
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <script src="{{ asset('js/bs-modal-fullscreen.min.js') }}" defer></script>
    <script src="{{ asset('js/project-calendar.js').'?v='.config('view.public_versioning') }}" defer></script>
@endsection
