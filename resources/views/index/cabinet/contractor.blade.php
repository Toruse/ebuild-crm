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
        var routeUpdateEvents = '{{ route('cabinet.contractor') }}';
        var events = [
            @if ($tasks && $tasks->isNotEmpty())
                @foreach($tasks as $task)
                {
                    id: {{ $task->id }},
                    title : '{{ $task->name }}',
                    start : '{{ $task->start_date }}',
                    end : '{{ $task->end_date_calendar }}',
                    textColor: 'white',
                    color: '{{ $task->color }}',
                },
                @endforeach
            @endif
        ];
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <script src="{{ asset('js/cabinet-contractor.js').'?v='.config('view.public_versioning') }}" defer></script>
@endsection
