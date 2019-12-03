<div class="modal fade" id="addScheduleTask" tabindex="-1" role="dialog" aria-labelledby="addScheduleTaskLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open([
                'route' => 'schedule-tasks.change',
                'method' => 'post',
            ]) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addScheduleTaskLabel">Add Task</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! Form::hidden('schedule', $schedule_id) !!}
                        <div class="col-md-6 form-group">
                            {!! Form::label('bind_users', 'Contractor', ['label' => 'sr-only']) !!}
                            {!! Form::select('bind_users[]', $listBindUsers, null, [
                                'class' => 'form-control input-select-2-multiple-bind-users-add', 
                                'multiple' => 'multiple',
                                'data-placeholder' => '-- Assign to --'
                            ]) !!}
                            @component('form.error', ['name' => 'bind_users'])@endcomponent
                        </div>           
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            {!! Form::label('type', 'Name/Type') !!}
                            <div class="input-group">
                                {!! Form::select('type', $listTaskTypes, null, [
                                    'class' => 'form-control input-select-2-multiple-add',
                                    'id' => 'task-type-add',
                                ]) !!}
                                <div class="input-group-addon">
                                    <a href="#" data-toggle="modal" data-target="#addTaskType"><i class="text-success fa fa-plus fa-lg"></i></a>
                                </div>
                            </div>                                                  
                            <div class="text-danger"></div>
                        </div>    
                        <div class="col-md-6 form-group">
                            {!! Form::label('color', 'Color') !!}
                            <div class="input-group colorpicker-input"> 
                                {!! Form::text('color', sprintf("#%06x",rand(0,16777215)), ['class' => 'form-control']) !!}
                                <span class="input-group-addon"><i></i></span> 
                            </div>
                            <div class="text-danger"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            {!! Form::label('start_date', 'Start Date') !!}
                            {!! Form::text('start_date', \Carbon\Carbon::now()->format('d F Y'), ['class' => 'form-control datepicker']) !!}
                            <div class="text-danger"></div>
                        </div>    
                        <div class="col-md-6 form-group">
                            {!! Form::label('end_date', 'End Date') !!}
                            {!! Form::text('end_date', \Carbon\Carbon::now()->format('d F Y'), ['class' => 'form-control datepicker']) !!}
                            <div class="text-danger"></div>
                        </div> 
                    </div>
                    <div class="row">           
                        <div class="col-md-12 form-group">
                            {!! Form::label('note', 'Note') !!}
                            {!! Form::textArea('note', '', ['class' => 'form-control', 'rows' => 5]) !!}
                            <div class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add-task-to-schedule">Add to Schedule</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>