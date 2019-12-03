@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('nav.nav-left-setting', [
                'select' => 'schedules'
            ])
        </div>        
        <div class="col-md-9"> 
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-primary" href="{{ route('schedules.edit', ['shedule' => $schedule]) }}">Edit</a>
                    <form class="delete-form" method="post" action="{{ route('schedules.destroy', ['user' => $schedule]) }}" style="display: inline">
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
                                <th>Title</th> 
                                <td>{{ $schedule->title }}</td>
                            </tr>
                            <tr> 
                                <th>Description</th> 
                                <td>{{ $schedule->description }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($schedule->tasks && $schedule->tasks->isNotEmpty())
                        <h4>Task</h3>
                        <table class="table">
                            <thead>
                                <th>Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </thead>
                            <tbody>
                                @each('project.schedule-task.index.view', $schedule->tasks, 'task')
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection