@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('nav.nav-left-setting', [
                'select' => 'sources'
            ])
        </div>        
        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                    <h2>View Source</h2>
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12">
                    <br>
                    <a class="btn btn-primary" href="{{ route('sources.edit', ['source' => $source]) }}">Edit</a>
                    <form class="delete-form" method="post" action="{{ route('sources.destroy', ['source' => $source]) }}" style="display: inline">
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
                                <td>{{ $source->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection