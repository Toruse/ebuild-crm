@extends('layouts.app')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="calendar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var routeUpdateEvents = '{{ route('cabinet.client') }}';
        var events = [
            @if ($projects->isNotEmpty())
                @foreach($projects as $project)
                {
                    id: {{ $project->id }},
                    title: '{{ $project->customerFullName }}',
                    start: '{{ $project->start_date }}',
                    end: '{{ $project->end_date_calendar }}',
                    textColor: 'white',
                    color: '{{ $project->color }}',
                },
                @endforeach
            @endif
        ];
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <script src="{{ asset('js/cabinet-client.js').'?v='.config('view.public_versioning') }}" defer></script>
@endsection
