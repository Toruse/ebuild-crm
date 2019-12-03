@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('nav.nav-left-setting', [
                'select' => 'skill-specialtys'
            ])
        </div>        
        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Skill/Specialty</h3>
                </div>        
                <div class="col-lg-6 text-right">
                    <br>
                    <a class="btn btn-success" href="{{ route('skill-specialtys.create') }}">Add Skill/Specialty</a>
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12">
                    @if ($skillSpecialtys->isNotEmpty())
                        <table class="table">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th></th>
                            </thead>
                            <tbody>

                                @each('setting.skill-specialty.crud.item', $skillSpecialtys, 'skillSpecialty')

                            </tbody>
                        </table>
                        {{ $skillSpecialtys->links() }}
                    @else
                        <p class="text-center">
                            No results found.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
