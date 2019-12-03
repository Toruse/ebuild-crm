@extends('layouts.app')

@section('css')
    <link id="bsdp-css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-primary" href="{{ route('projects') }}"><< Back to All Projects</a><br><br>
                </div>
            </div>
            {!! Form::open([
                'route' => 'projects.store',
                'method' => 'post'
            ]) !!}
            <div class="row">
                <div class="col-md-6">   
                    <div class="form-group">
                        {!! Form::label('customer', 'Client Name', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('customer', $listCustomerUsers, null, [
                                'class' => 'form-control',
                                'data-action' => route('get-info-user-project', ['user' => null]),
                            ]) !!}
                        </div>
                        @component('form.error', ['name' => 'customer'])@endcomponent
                    </div> 
                </div>
                <div class="col-md-6 text-right">
                    {!! Form::submit('Save',[
                        'class' => 'btn btn-success'
                    ]) !!}
                    <a class="btn btn-primary" href="{{ route('projects') }}">Cancel</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <br>
                    {!! Form::label('price', 'Contract Price') !!}
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        {!! Form::text('price', '', ['class' => 'form-control']) !!}
                    </div>
                    @component('form.error', ['name' => 'price'])@endcomponent
                </div>
                <div class="col-md-6 form-group">
                    <br>
                    {!! Form::label('type', 'Remodel Type') !!}
                    {!! Form::select('type', $listProjectType, 0, ['class' => 'form-control']) !!}
                    @component('form.error', ['name' => 'type'])@endcomponent
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    {!! Form::label('address', 'Address') !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    {!! Form::text('street_address1', '', ['class' => 'form-control', 'placeholder' => 'Street 1']) !!}
                    @component('form.error', ['name' => 'street_address1'])@endcomponent
                </div>
                <div class="col-md-6 form-group">
                    {!! Form::text('street_address2', '', ['class' => 'form-control', 'placeholder' => 'Street 2']) !!}
                    @component('form.error', ['name' => 'street_address2'])@endcomponent
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    {!! Form::text('city', '', ['class' => 'form-control', 'placeholder' => 'City']) !!}
                    @component('form.error', ['name' => 'city'])@endcomponent
                </div>
                <div class="col-md-3 form-group">
                    {!! Form::text('state', '', ['class' => 'form-control', 'placeholder' => 'State']) !!}
                    @component('form.error', ['name' => 'state'])@endcomponent
                </div>
                <div class="col-md-3 form-group">
                    {!! Form::text('postal_code', '', [
                        'class' => 'form-control postal_code', 
                        'placeholder' => 'Zip'
                    ]) !!}
                    @component('form.error', ['name' => 'postal_code'])@endcomponent
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    {!! Form::label('project_manager', 'Project Manager') !!}
                    {!! Form::select('project_manager', $listProjectManager, null, ['class' => 'form-control']) !!}
                    @component('form.error', ['name' => 'project_manager'])@endcomponent
                </div>
                <div class="col-md-6 form-group">
                    {!! Form::label('color', 'Color') !!}
                    <div class="input-group colorpicker-input"> 
                        {!! Form::text('color', sprintf("#%06x",rand(0,16777215)), ['class' => 'form-control']) !!}
                        <span class="input-group-addon"><i></i></span> 
                    </div>
                    @component('form.error', ['name' => 'color'])@endcomponent
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    {!! Form::label('start_date', 'Start Date') !!}
                    {!! Form::text('start_date', $select_date?:\Carbon\Carbon::now()->format('d F Y'), ['class' => 'form-control datepicker']) !!}
                    @component('form.error', ['name' => 'start_date'])@endcomponent
                </div>    
                <div class="col-md-6 form-group">
                    {!! Form::label('end_date', 'End Date') !!}
                    {!! Form::text('end_date', null, ['class' => 'form-control datepicker']) !!}
                    @component('form.error', ['name' => 'end_date'])@endcomponent
                </div> 
            </div>
            <div class="row">   
                <div class="col-md-12 form-group">
                    {!! Form::label('schedule', 'Schedule') !!}<br>
                    <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addTask">Add Task</a>
                    <a class="btn btn-success load-select-schedule" href="#" data-action="{{ route('projects.get-list') }}">Load Template</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 task-index">
                    <br>
                    @include('project.task.index')
                </div>    
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@include('project.task.form.modal.add')
@include('project.task.form.modal.edit')

@include('project.schedule.form.modal.select')
@include('project.schedule.form.modal.iframe')
@include('project.schedule.form.modal.add-modal', ['modal' => '2'])

@include('setting.task-type.form.modal.add')

@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/bs-modal-fullscreen.min.js') }}" defer></script>
    <script src="{{ asset('js/project.js').'?v='.config('view.public_versioning') }}" defer></script>
@endsection

