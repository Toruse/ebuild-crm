@extends('layouts.app')

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
                    <h2>View Priced</h2>
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12">
                    <br>
                    <a class="btn btn-primary" href="{{ route('priceds.edit', ['priced' => $priced]) }}">Edit</a>
                    <form class="delete-form" method="post" action="{{ route('priceds.destroy', ['priced' => $priced]) }}" style="display: inline">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div> 
            <div class="row">
                <div class="col-lg-12">
                    <br>
                    <table class="table"> 
                        <tbody>
                            <tr> 
                                <th>Name</th> 
                                <td>{{ $priced->name }}</td>
                            </tr>
                            <tr> 
                                <th>Type</th> 
                                <td>{{ $priced->type?$listType[$priced->type]:'' }}</td>
                            </tr>
                            <tr> 
                                <th>Default</th> 
                                <td>@if ($priced->default) Yes @else No @endif</td>
                            </tr>
                            <tr> 
                                <th>Repeat</th> 
                                <td>@if ($priced->repeat) Yes @else No @endif</td>
                            </tr>
                            <tr> 
                                <th>Period</th> 
                                <td>{{ $priced->period }}</td>
                            </tr>
                            <tr> 
                                <th>Period Type</th> 
                                <td>{{ $listPeriodType[$priced->period_type] }}</td>
                            </tr>
                            <tr> 
                                <th>Price</th> 
                                <td>{{ $priced->price }}</td>
                            </tr>
                            <tr> 
                                <th>End Date</th> 
                                <td>{{ $priced->form_end_date }}</td>
                            </tr>
                            <tr> 
                                <th>Note</th> 
                                <td>{{ $priced->note }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection