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
            {!! Form::open([
                'route' => ['priceds.update', $priced],
                'method' => 'PUT'
            ]) !!}
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Update Priced</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        {!! Form::label('name', 'Name') !!} <span class="text-danger">*</span>
                        {!! Form::text('name', $priced->name, ['class' => 'form-control']) !!}
                        @component('form.error', ['name' => 'name'])@endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        {!! Form::label('type', 'Type') !!}
                        {!! Form::select('type', $listType, $priced->type, ['class' => 'form-control']) !!}
                        @component('form.error', ['name' => 'type'])@endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        {!! Form::hidden('default', 0) !!}
                        {!! Form::checkbox('default', 1, $priced->default) !!}
                        {!! Form::label('default', 'Default') !!}
                        @component('form.error', ['name' => 'default'])@endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        {!! Form::hidden('repeat', 0) !!}
                        {!! Form::checkbox('repeat', 1, $priced->repeat) !!}
                        {!! Form::label('repeat', 'Repeat') !!}
                        @component('form.error', ['name' => 'repeat'])@endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        {!! Form::label('period', 'Period') !!}
                        {!! Form::text('period', $priced->period, ['class' => 'form-control']) !!}
                        @component('form.error', ['name' => 'period'])@endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        {!! Form::label('period_type', 'Period Type') !!}
                        {!! Form::select('period_type', $listPeriodType, $priced->period_type, ['class' => 'form-control']) !!}
                        @component('form.error', ['name' => 'period_type'])@endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        {!! Form::label('price', 'Price') !!}
                        {!! Form::text('price', $priced->price, ['class' => 'form-control']) !!}
                        @component('form.error', ['name' => 'price'])@endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        {!! Form::label('end_date', 'End Date') !!}
                        {!! Form::text('end_date', $priced->form_end_date, ['class' => 'form-control datepicker']) !!}
                        @component('form.error', ['name' => 'end_date'])@endcomponent
                    </div> 
                </div>
                <div class="row">           
                    <div class="col-md-6 form-group">
                        {!! Form::label('note', 'Note') !!}
                        {!! Form::textArea('note', $priced->note, ['class' => 'form-control', 'rows' => 5]) !!}
                        <div class="text-danger"></div>
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