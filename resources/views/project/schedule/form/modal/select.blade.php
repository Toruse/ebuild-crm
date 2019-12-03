<div class="modal fade bs-example-modal-lg" id="selectSchedule" tabindex="-1" role="dialog" aria-labelledby="selectScheduleLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open([
                'route' => 'schedules.select',
                'method' => 'post',
                'id' => 'form-select-schedule'
            ]) !!}
                {!! Form::hidden('project', $project_id) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="selectScheduleLabel">Select Schedule</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            {!! Form::label('start_date', 'Start Date') !!}
                            {!! Form::text('start_date', \Carbon\Carbon::now()->format('d F Y'), ['class' => 'form-control datepicker']) !!}
                            <div class="text-danger"></div>
                        </div>    
                    </div>
        
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="schedule" class="hidden"></label>
                            <div class="text-danger"></div>
                            <div class="list-schedule">                           
                                @if ($schedules->isNotEmpty())
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Choose</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @each('project.schedule.index.select', $schedules, 'schedule')
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-center">
                                        No results found.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-6 text-left">
                            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addSchedule">Add New Template</a>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-primary" id="select-schedule">Apply Template</button>
                        </div>
                    </div>
                
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>