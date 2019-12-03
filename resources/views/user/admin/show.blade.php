@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('user.nav-top-tabs')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <br>
            <a class="btn btn-primary" href="{{ route('admins.edit', ['user' => $user]) }}">Edit</a>
            <form class="delete-form" method="post" action="{{ route('admins.destroy', ['user' => $user]) }}" style="display: inline">
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
                        <th>First Name</th> 
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr> 
                        <th>Lastname Name</th> 
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr> 
                        <th>Phone No.</th> 
                        <td>{{ $user->phone }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('admins.index') }}" class="btn btn-default" role="button">Back</a>
        </div>
    </div>
</div>
@endsection