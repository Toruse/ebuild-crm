@extends('layouts.app-modal')

@section('css')
    <link id="bsdp-css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            {!! Form::open([
                'route' => ['schedules.update', $schedule, 'modal' => $modal],
                'method' => 'PUT'
            ]) !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-9 show-schedule-title">
                            {{$schedule->title}}
                        </div>
                        <div class="col-md-3 text-right">
                            <i class="fa fa-edit fa-lg button-edit-schedule button-edit-project-style"></i>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="show-schedule">
                        {{$schedule->description}}
                    </div>
                    <div class="edit-schedule hidden">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-primary" id="edit-schedule">Save</button>
                                <a class="btn btn-primary button-edit-schedule" href="#">Cancel</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <br>
                                {!! Form::label('title', 'Title') !!}
                                {!! Form::text('title', $schedule->title, ['class' => 'form-control']) !!}
                                @component('form.error', ['name' => 'title'])@endcomponent
                            </div>    
                            <div class="col-md-12 form-group">
                                {!! Form::label('description', 'Description') !!}
                                {!! Form::textArea('description', $schedule->description, [
                                    'class' => 'form-control',
                                    'rows' => 5
                                ]) !!}
                                @component('form.error', ['name' => 'description'])@endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('schedules.index', ['modal' => $modal]) }}" class="btn btn-default close-iframe">Back</a>
                    <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addScheduleTask">Add Task</a>
                    {!! Form::submit('Save Template',[
                        'class' => 'btn btn-primary'
                    ]) !!}
                </div>
            </div>
            {!! Form::close() !!}
            <div class="task-index">
                <br>
                @include('project.schedule-task.index')
            </div> 
        </div>
        <div class="col-md-7">
            <div class="calendar-edit">
            </div>
        </div> 
    </div>
</div>

@include('project.schedule-task.form.modal.add')
@include('project.schedule-task.form.modal.edit')

@include('setting.task-type.form.modal.add')

@endsection

@section('javascript')
    <script>
        var modal = {{ $modal?$modal:'' }};

        var events = [
            @if ($tasks && $tasks->isNotEmpty())
                @foreach($tasks as $task)
                {
                    id: {{ $task->id }},
                    title : '{{ $task->name }}',
                    start : '{{ $task->start_date }}',
                    end : '{{ $task->end_date_calendar }}',
                    url : '{{ route('schedule-tasks.edit', ['scheduleTask' => $task]) }}',
                    textColor: 'white',
                    color: '{{ $task->color }}',
                    data: {
                        urlEventDrop: '{{ route('schedule-tasks.event-drop', ['scheduleTask' => $task]) }}',
                        urlEventResize: '{{ route('schedule-tasks.event-resize', ['scheduleTask' => $task]) }}',
                    }
                },
                @endforeach
            @endif
        ];

        var defaultDate = '{{ $defaultDate }}';
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/schedule-calendar.js').'?v='.config('view.public_versioning') }}" defer></script>
    <script src="{{ asset('js/schedule.js').'?v='.config('view.public_versioning') }}" defer></script>
    <script src="{{ asset('js/iframe.js').'?v='.config('view.public_versioning') }}"></script>
@endsection

