@extends('layouts.app')

@section('css')
    <link id="bsdp-css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <a class="btn btn-primary" href="{{ route('projects') }}"><< Back to All Projects</a><br><br>
        </div>
        <div class="col-md-6 text-right project-edit-hidden">
            <button 
                type="button" 
                class="btn btn-info button-project-unpublished{{ $project->publish?'':' hidden' }}"
                data-action="{{ route('projects.publish', ['project' => $project]) }}"
                value="0"
            >
                Unpublished
            </button>
            <button 
                type="button" 
                class="btn btn-danger button-project-publish{{ $project->publish?' hidden':'' }}"
                data-action="{{ route('projects.publish', ['project' => $project]) }}"
                value="1"
            >
                Publish
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: {{ $project->color }}">
                    <div class="row">
                        <div class="col-md-9">
                            {{ $project->customerFullName }} | {{ $project->typeName }}<br>
                            {{ $project->user_start_date }} - {{ $project->user_end_date }}
                        </div>
                        <div class="col-md-3 text-right">
                            <i class="fa fa-edit fa-lg button-edit-project button-edit-project-style project-edit-hidden" data-action="{{ route('projects.edit-json', ['project' => $project]) }}"></i>
                            <form class="delete-form" method="post" action="{{ route('projects.destroy', ['project' => $project]) }}" style="display: inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                    
                                <button type="submit" class="button-bg-clear button-delete-project button-delete-project-style"><i class="fa fa-trash fa-lg"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel-body show-project">
                    @include('project.project.info', [
                        'project' => $project
                    ])
                </div>
            </div>
            <div class="edit-project hidden">
                {!! Form::open([
                    'route' => ['projects.update', $project],
                    'method' => 'PUT',
                    'id' => 'form-edit-project'
                ]) !!}
                <div class="row">
                    <div class="col-md-6">   
                        <div class="form-group">
                            {!! Form::label('customer', 'Client Name', ['class' => 'control-label hidden']) !!}
                            {!! Form::select('customer', $listCustomerUsers, $project->customer_id, [
                                'class' => 'form-control',
                                'data-action' => route('get-info-user-project', ['user' => null]),
                            ]) !!}
                            <div class="text-danger"></div>
                        </div> 
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary" id="edit-project">Save</button>
                        <a class="btn btn-primary button-edit-project" href="#">Cancel</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <br>
                        {!! Form::label('price', 'Contract Price') !!}
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!! Form::text('price', $project->price, ['class' => 'form-control']) !!}
                        </div>
                        <div class="text-danger"></div>
                    </div>
                    <div class="col-md-6 form-group">
                        <br>
                        {!! Form::label('type', 'Remodel Type') !!}
                        {!! Form::select('type', $listProjectType, $project->project_type_id, ['class' => 'form-control']) !!}
                        <div class="text-danger"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        {!! Form::label('address', 'Address') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        {!! Form::text('street_address1', $project->street_address1, ['class' => 'form-control', 'placeholder' => 'Street 1']) !!}
                        <div class="text-danger"></div>
                    </div>
                    <div class="col-md-6 form-group">
                        {!! Form::text('street_address2', $project->street_address2, ['class' => 'form-control', 'placeholder' => 'Street 2']) !!}
                        <div class="text-danger"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        {!! Form::text('city', $project->city, ['class' => 'form-control', 'placeholder' => 'City']) !!}
                        <div class="text-danger"></div>
                    </div>
                    <div class="col-md-3 form-group">
                        {!! Form::text('state', $project->state, ['class' => 'form-control', 'placeholder' => 'State']) !!}
                        <div class="text-danger"></div>
                    </div>
                    <div class="col-md-3 form-group">
                        {!! Form::text('postal_code', $project->postal_code, [
                            'class' => 'form-control postal_code', 
                            'placeholder' => 'Zip'
                        ]) !!}
                        <div class="text-danger"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        {!! Form::label('project_manager', 'Project Manager') !!}
                        {!! Form::select('project_manager', $listProjectManager, $project->project_manager_id, ['class' => 'form-control']) !!}
                        <div class="text-danger"></div>
                    </div>
                    <div class="col-md-6 form-group">
                        {!! Form::label('color', 'Color') !!}
                        <div class="input-group colorpicker-input"> 
                            {!! Form::text('color', $project->color, ['class' => 'form-control']) !!}
                            <span class="input-group-addon"><i></i></span> 
                        </div>
                        <div class="text-danger"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        {!! Form::label('start_date', 'Start Date') !!}
                        {!! Form::text('start_date', $project->user_start_date, ['class' => 'form-control datepicker']) !!}
                        <div class="text-danger"></div>
                    </div>    
                    <div class="col-md-6 form-group">
                        {!! Form::label('end_date', 'End Date') !!}
                        {!! Form::text('end_date', $project->user_end_date, ['class' => 'form-control datepicker']) !!}
                        <div class="text-danger"></div>
                    </div>    
                </div>
                {!! Form::close() !!}
            </div>
            <div class="row project-edit-hidden">
                <div class="col-md-3">
                    <a class="btn btn-success btn-sm btn-block" href="#" data-toggle="modal" data-target="#addTask">Add Task</a>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-success btn-sm btn-block load-select-schedule" href="#" data-action="{{ route('projects.get-list') }}">Load Template</a>
                </div>
                <div class="col-md-5">
                    <a class="btn btn-default btn-sm btn-block" href="#" data-toggle="modal" data-target="#indexSchedule">View/Edit Templates</a>
                </div>
            </div>
            <div class="task-index">
                <br>
                @include('project.task.index')
            </div>    
        </div>
        <div class="col-md-8">
            <div class="calendar-edit">
            </div>
        </div>    
    </div>
</div>

@include('project.task.form.modal.add')
@include('project.task.form.modal.edit')

@include('project.schedule.form.modal.select')
@include('project.schedule.form.modal.index')
@include('project.schedule.form.modal.iframe')
@include('project.schedule.form.modal.add-modal', ['modal' => '2'])

@include('setting.task-type.form.modal.add')

@endsection

@section('javascript')
    <script>
        var publishProject = {{ $project->publish }};
        var events = [
            @if ($tasks && $tasks->isNotEmpty())
                @foreach($tasks as $task)
                {
                    id: {{ $task->id }},
                    title : '{{ $task->name }}',
                    start : '{{ $task->start_date }}',
                    end : '{{ $task->end_date_calendar }}',
                    url : '{{ route('tasks.edit', ['task' => $task]) }}',
                    textColor: 'white',
                    color: '{{ $task->color }}',
                    data: {
                        urlEventDrop: '{{ route('tasks.event-drop', ['task' => $task]) }}',
                        urlEventResize: '{{ route('tasks.event-resize', ['task' => $task]) }}',
                    }
                },
                @endforeach
            @endif
        ];
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/bs-modal-fullscreen.min.js') }}" defer></script>
    <script src="{{ asset('js/notify.min.js') }}" defer></script>
    <script src="{{ asset('js/project-calendar.js').'?v='.config('view.public_versioning') }}" defer></script>
    <script src="{{ asset('js/project.js').'?v='.config('view.public_versioning') }}" defer></script>
@endsection

