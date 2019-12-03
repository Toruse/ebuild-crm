@extends('layouts.app')

@section('css')
    <link id="bsdp-css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('nav.nav-left-setting', [
                'select' => 'priceds'
            ])
        </div>        
        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Add Priced</h2>
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::open([
                        'route' => 'priceds.store',
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
                            <div class="col-lg-6 form-group">
                                {!! Form::label('type', 'Type') !!}
                                {!! Form::select('type', $listType, 1, ['class' => 'form-control']) !!}
                                @component('form.error', ['name' => 'type'])@endcomponent
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                {!! Form::hidden('default', 0) !!}
                                {!! Form::checkbox('default', 1) !!}
                                {!! Form::label('default', 'Default') !!}
                                @component('form.error', ['name' => 'default'])@endcomponent
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                {!! Form::hidden('repeat', 0) !!}
                                {!! Form::checkbox('repeat', 1) !!}
                                {!! Form::label('repeat', 'Repeat') !!}
                                @component('form.error', ['name' => 'repeat'])@endcomponent
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                {!! Form::label('period', 'Period') !!}
                                {!! Form::text('period', '', ['class' => 'form-control']) !!}
                                @component('form.error', ['name' => 'period'])@endcomponent
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                {!! Form::label('period_type', 'Period Type') !!}
                                {!! Form::select('period_type', $listPeriodType, 1, ['class' => 'form-control']) !!}
                                @component('form.error', ['name' => 'period_type'])@endcomponent
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                {!! Form::label('price', 'Price') !!}
                                {!! Form::text('price', '', ['class' => 'form-control']) !!}
                                @component('form.error', ['name' => 'price'])@endcomponent
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                {!! Form::label('end_date', 'End Date') !!}
                                {!! Form::text('end_date', null, ['class' => 'form-control datepicker']) !!}
                                @component('form.error', ['name' => 'end_date'])@endcomponent
                            </div> 
                        </div>
                        <div class="row">           
                            <div class="col-md-6 form-group">
                                {!! Form::label('note', 'Note') !!}
                                {!! Form::textArea('note', '', ['class' => 'form-control', 'rows' => 5]) !!}
                                <div class="text-danger"></div>
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

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(function() {
            $('.datepicker').datepicker({
                format: "dd MM yyyy",
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
@endsection