@extends('layouts.app-modal')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 col-md-offset-1 text-right">
            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addSchedule">Add New Template</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 col-md-offset-1">
            @if ($schedules->isNotEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @each('project.schedule.index.item-modal', $schedules, 'schedule')

                    </tbody>
                </table>
                {{ $schedules->links() }}
            @else
                <p class="text-center">
                    No results found.
                </p>
            @endif
        </div>
    </div>
</div>

@include('project.schedule.form.modal.add-modal')
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/schedule.js').'?v='.config('view.public_versioning') }}" defer></script>
@endsection