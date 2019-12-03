@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('nav.nav-left-setting', [
                'select' => 'task-types'
            ])
        </div>        
        <div class="col-md-9"> 
            {!! Form::open([
                'route' => ['task-types.update', $type],
                'method' => 'PUT'
            ]) !!}
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Update Type</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        {!! Form::label('name', 'Name') !!} <span class="text-danger">*</span>
                        {!! Form::text('name', $type->name, ['class' => 'form-control']) !!}
                        @component('form.error', ['name' => 'name'])@endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {!! Form::submit('Edit',[
                            'class' => 'btn btn-primary'
                        ]) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection