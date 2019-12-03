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
            <a class="btn btn-primary" href="{{ route('customers.edit', ['user' => $user]) }}">Edit</a>
            <form class="delete-form" method="post" action="{{ route('customers.destroy', ['user' => $user]) }}" style="display: inline">
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
                    @if ($user->profile) 
                        <tr> 
                            <th>First Name</th> 
                            <td>{{ $user->profile->firstname }}</td>
                        </tr>
                        <tr> 
                            <th>Lastname Name</th> 
                            <td>{{ $user->profile->lastname }}</td>
                        </tr>
                        <tr> 
                            <th>Email</th> 
                            <td>{{ $user->profile->email }}</td>
                        </tr>
                    @endif
                        <tr> 
                            <th>Phone No.</th> 
                            <td>{{ $user->phone }}</td>
                        </tr>
                    @if ($user->profile) 
                        <tr> 
                            <th>Street Address Line 1</th> 
                            <td>{{ $user->profile->street_address1 }}</td>
                        </tr>
                        <tr> 
                            <th>Street Address Line 2</th> 
                            <td>{{ $user->profile->street_address2 }}</td>
                        </tr>
                        <tr> 
                            <th>City</th> 
                            <td>{{ $user->profile->city }}</td>
                        </tr>
                        <tr> 
                            <th>State</th> 
                            <td>{{ $user->profile->state }}</td>
                        </tr>
                        <tr> 
                            <th>Postal Code</th> 
                            <td>{{ $user->profile->postal_code }}</td>
                        </tr>
                    @endif
                    @if (($order = $user->orders->first()))
                        @if ($order->projectManager && $order->projectManager->profile) 
                        <tr> 
                            <th>Assigned To</th> 
                            <td>{{ $order->projectManager->full_name }}</td>
                        </tr>
                        @endif
                        @if ($order->projectType) 
                            <tr> 
                                <th>Project Type</th> 
                                <td>{{ $order->projectType->name }}</td>
                            </tr>
                        @endif
                        <tr> 
                            <th>Status</th> 
                            <td>{{ App\Models\User\Order::getLabelStatus($order->status) }}</td>
                        </tr>
                    @endif
                    @if ($user->profile) 
                        @if ($user->profile->source) 
                            <tr> 
                                <th>Source</th> 
                                <td>{{ $user->profile->source->name }}</td>
                            </tr>
                        @endif
                        <tr> 
                            <th>Notes</th> 
                            <td>{{ $user->profile->note }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('customers.index') }}" class="btn btn-default" role="button">Back</a>
        </div>
    </div>
</div>
@endsection