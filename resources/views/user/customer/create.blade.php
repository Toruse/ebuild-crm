@extends('layouts.app')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('user.nav-top-tabs')
        </div>
    </div>
    {!! Form::open([
        'route' => 'customers.store',
        'method' => 'post'
    ]) !!}
        <div class="row">
            <div class="col-lg-12">
                <h2>Add Client</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('firstname', 'First Name') !!} <span class="text-danger">*</span>
                {!! Form::text('firstname', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'firstname'])@endcomponent
            </div>
            <div class="col-lg-6 form-group">
                {!! Form::label('lastname', 'Last Name') !!}
                {!! Form::text('lastname', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'lastname'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::text('email', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'email'])@endcomponent
            </div>
            <div class="col-lg-6 form-group">
                {!! Form::label('phone', 'Phone No.') !!} <span class="text-danger">*</span>
                {!! Form::text('phone', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'phone'])@endcomponent
            </div>    
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('street_address1', 'Street Address Line 1') !!}
                {!! Form::text('street_address1', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'street_address1'])@endcomponent
            </div>
            <div class="col-lg-6 form-group">
                {!! Form::label('street_address2', 'Street Address Line 2') !!}
                {!! Form::text('street_address2', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'street_address2'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('city', 'City') !!}
                {!! Form::text('city', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'city'])@endcomponent
            </div>
            <div class="col-lg-6 form-group">
                {!! Form::label('state', 'State') !!}
                {!! Form::text('state', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'state'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('postal_code', 'Postal Code') !!}
                {!! Form::text('postal_code', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'postal_code'])@endcomponent
            </div>
            <div class="col-lg-6 form-group">
                {!! Form::label('project_manager', 'Assigned To') !!}
                {!! Form::select('project_manager', $listProjectManager, $project_manager_id, ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'project_manager'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('source', 'Source', ['label' => 'sr-only']) !!}
                <div class="input-group">
                    {!! Form::select('source', $listSources, null, ['class' => 'form-control']) !!}
                    <div class="input-group-addon">
                        <a href="#" data-toggle="modal" data-target="#addSource"><i class="text-success fa fa-plus fa-lg"></i></a>
                    </div>
                </div>
                @component('form.error', ['name' => 'source'])@endcomponent
            </div>
            <div class="col-lg-6 form-group">
                {!! Form::label('project_type', 'Project Type', ['label' => 'sr-only']) !!}
                <div class="input-group">
                    {!! Form::select('project_type', $listProjectType, null, ['class' => 'form-control']) !!}
                    <div class="input-group-addon">
                        <a href="#" data-toggle="modal" data-target="#addProjectType"><i class="text-success fa fa-plus fa-lg"></i></a>
                    </div>
                </div>
                @component('form.error', ['name' => 'project_type'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('status', 'Status') !!}
                {!! Form::select('status', $listStatus, null, ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'status'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 form-group">
                {!! Form::label('note', 'Notes') !!}
                {!! Form::textArea('note', '', [
                    'class' => 'form-control',
                    'rows' => 5
                ]) !!}
                @component('form.error', ['name' => 'note'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <a href="{{ route('customers.index') }}" class="btn btn-default" role="button">Back</a>                                                                                                                                                                                
                {!! Form::submit('Create',[
                    'class' => 'btn btn-success'
                ]) !!}
            </div>
        </div>
    {!! Form::close() !!}
</div>

@include('setting.source.form.modal.add')
@include('setting.project-type.form.modal.add')

@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/user.js').'?v='.config('view.public_versioning') }}" defer></script>
@endsection