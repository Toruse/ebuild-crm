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
        'route' => 'vendors.store',
        'method' => 'post'
    ]) !!}
        <div class="row">
            <div class="col-lg-12">
                <h2>Add Vendor</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('company', 'Company') !!} <span class="text-danger">*</span>
                {!! Form::text('company', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'company'])@endcomponent
            </div>
            <div class="col-lg-6 form-group">
                {!! Form::label('firstname', 'First Name') !!} <span class="text-danger">*</span>
                {!! Form::text('firstname', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'firstname'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('lastname', 'Last Name') !!}
                {!! Form::text('lastname', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'lastname'])@endcomponent
            </div>
            <div class="col-lg-6 form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::text('email', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'email'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('phone', 'Phone No.') !!} <span class="text-danger">*</span>
                {!! Form::text('phone', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'phone'])@endcomponent
            </div>    
            <div class="col-lg-6 form-group">
                {!! Form::label('street_address1', 'Street Address Line 1') !!}
                {!! Form::text('street_address1', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'street_address1'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('street_address2', 'Street Address Line 2') !!}
                {!! Form::text('street_address2', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'street_address2'])@endcomponent
            </div>
            <div class="col-lg-6 form-group">
                {!! Form::label('city', 'City') !!}
                {!! Form::text('city', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'city'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('state', 'State') !!}
                {!! Form::text('state', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'state'])@endcomponent
            </div>
            <div class="col-lg-6 form-group">
                {!! Form::label('postal_code', 'Postal Code') !!}
                {!! Form::text('postal_code', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'postal_code'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('website', 'Website') !!}
                {!! Form::text('website', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'website'])@endcomponent
            </div>
            <div class="col-lg-6 form-group">
                {!! Form::label('fax_number', 'Fax Number') !!}
                {!! Form::text('fax_number', '', ['class' => 'form-control']) !!}
                @component('form.error', ['name' => 'fax_number'])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                {!! Form::label('material_service', 'Material/Service', ['label' => 'sr-only']) !!}
                {!! Form::select('material_service[]', $listMaterialService, null, [
                    'class' => 'form-control input-select-2-multiple-add', 
                    'multiple' => 'multiple',
                    'data-placeholder' => 'e.g. Tile, Stone, Cabinets'
                ]) !!}
                @component('form.error', ['name' => 'material_service'])@endcomponent
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
                <a href="{{ route('vendors.index') }}" class="btn btn-default" role="button">Back</a>
                {!! Form::submit('Create',[
                    'class' => 'btn btn-success'
                ]) !!}
            </div>
        </div>
    {!! Form::close() !!}
</div>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/user.js').'?v='.config('view.public_versioning') }}" defer></script>
@endsection