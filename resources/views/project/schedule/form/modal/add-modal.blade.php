<div class="modal fade" id="addSchedule" tabindex="-1" role="dialog" aria-labelledby="addScheduleLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open([
                'route' => ['schedules.store', 'modal' => $modal],
                'method' => 'post',
            ]) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addScheduleLabel">Create New Template</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            {!! Form::label('title', 'Title') !!}
                            {!! Form::text('title', '', ['class' => 'form-control']) !!}
                            <div class="text-danger"></div>
                        </div>    
                        <div class="col-md-12 form-group">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::textArea('description', '', [
                                'class' => 'form-control', 'rows' => 5
                            ]) !!}
                            <div class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add-schedule">Save</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>