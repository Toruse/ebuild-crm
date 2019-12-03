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
        'route' => ['user-setting.update', $user],
        'method' => 'PUT'
    ]) !!}
        <div class="row">
            <div class="col-lg-12">
                <h2>User Settings: (ID: {{ $user->id }})</h2>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6 form-group">
                        {!! Form::label('role', 'Role') !!}
                        {!! Form::select('role', $listRoles, $user->roles, [
                            'class' => 'form-control',
                        ]) !!}
                        @component('form.error', ['name' => 'role'])@endcomponent
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6 form-group">
                        {!! Form::label('number', 'Number Renewals') !!}
                        {!! Form::text('number', null, ['class' => 'form-control']) !!}
                        @component('form.error', ['name' => 'firstname'])@endcomponent
                    </div>
                    <div class="col-lg-6 form-group">
                        {!! Form::label('priced', 'Priced') !!}
                        {!! Form::select('priced', $listPriced, $user->priceds, [
                            'class' => 'form-control',
                        ]) !!}
                        @component('form.error', ['name' => 'priced'])@endcomponent
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 form-group">                                                                                                                                                                        
                <a href="{{ URL::previous() }}" class="btn btn-default" role="button">Back</a>
                {!! Form::submit('Edit',[
                    'class' => 'btn btn-primary'
                ]) !!}
            </div>
        </div>
    {!! Form::close() !!}
</div>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/user-setting.js').'?v='.config('view.public_versioning') }}" defer></script>
@endsection