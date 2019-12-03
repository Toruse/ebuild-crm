@extends('layouts.app')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <h3>Contacts</h3>
        </div>
        <div class="col-lg-6 text-right">
            <br>
            <a class="btn btn-primary" href="{{ route('contacts.create') }}">Add Contact</a>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-12">
            @include('user.nav-top-tabs')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <br>
            <a class="btn btn-success" href="{{ route('customers.create') }}">Add Client</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @if ($users->isNotEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>

                        @each('user.customer.crud.item', $users, 'user')

                    </tbody>
                </table>
                {{ $users->links() }}
            @else
                <p class="text-center">
                    No results found.
                </p>
            @endif
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/notify.min.js') }}" defer></script>
    <script src="{{ asset('js/user.js').'?v='.config('view.public_versioning') }}" defer></script>
@endsection
