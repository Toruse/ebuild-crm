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
        'route' => 'admins.store',
        'method' => 'post'
    ]) !!}
        <div class="row">
            <div class="col-lg-12">
                <h2>Add Admin</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('firstname', 'First Name') !!} <span class="text-danger">*</span>
                {!! Form::text('firstname', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'firstname'])@endcomponent
            </div>
            <div class="col-lg-6 form-group">
                {!! Form::label('email', 'Email') !!} <span class="text-danger">*</span>
                {!! Form::text('email', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'email'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('password', 'Password') !!} <span class="text-danger">*</span>
                {!! Form::password('password', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'password'])@endcomponent
            </div>
            <div class="col-lg-6 form-group">
                {!! Form::label('password_confirmation', 'Confirm Password') !!} <span class="text-danger">*</span>
                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'password_confirmation'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('phone', 'Phone No.') !!} <span class="text-danger">*</span>
                {!! Form::text('phone', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'phone'])@endcomponent
            </div>                                                                                                                                                                        
        </div>
        <div class="row">
            <div class="col-lg-12">
                <a href="{{ route('admins.index') }}" class="btn btn-default" role="button">Back</a>                                                                                                                                                                        
                {!! Form::submit('Create',[
                    'class' => 'btn btn-success'
                ]) !!}
            </div>
        </div>
    {!! Form::close() !!}
    </div>
</div>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/user.js').'?v='.config('view.public_versioning') }}" defer></script>
@endsection