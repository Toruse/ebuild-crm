@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('nav.nav-left-setting', [
                'select' => 'project-types'
            ])
        </div>        
        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Add Type</h2>
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::open([
                        'route' => 'project-types.store',
                        'method' => 'post'
                    ]) !!}
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                {!! Form::label('name', 'Name') !!} <span class="text-danger">*</span>
                                {!! Form::text('name', '', ['class' => 'form-control']) !!}
                                @component('form.error', ['name' => 'name'])@endcomponent
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">                                                                                                                                                                        
                                {!! Form::submit('Create',[
                                    'class' => 'btn btn-success'
                                ]) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection