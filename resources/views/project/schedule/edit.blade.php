@extends('layouts.app')

@section('css')
    <link id="bsdp-css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('nav.nav-left-setting', [
                'select' => 'schedules'
            ])
        </div>        
        <div class="col-md-9">        
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open([
                        'route' => ['schedules.update', $schedule],
                        'method' => 'PUT'
                    ]) !!}
                    <div class="row">
                        <div class="col-md-12 text-right">
                            {!! Form::submit('Edit',[
                                'class' => 'btn btn-primary'
                            ]) !!}
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
                        <div class="col-md-12">
                            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addScheduleTask">Add Task</a>
                        </div>
                        <div class="col-md-12 task-index">
                            <br>
                            @include('project.schedule-task.index')
                        </div>   
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@include('project.schedule-task.form.modal.add')
@include('project.schedule-task.form.modal.edit')

@include('setting.task-type.form.modal.add')

@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/schedule.js').'?v='.config('view.public_versioning') }}" defer></script>
@endsection

