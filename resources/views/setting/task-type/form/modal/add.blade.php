<div class="modal fade" id="addTaskType" tabindex="-1" role="dialog" aria-labelledby="addTaskTypeLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open([
                'route' => 'task-types.addquick',
                'method' => 'post',
            ]) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addTaskTypeLabel">Create New Task Type</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', '', [
                                'class' => 'form-control',
                                'id' => 'task-type-name'
                            ]) !!}
                            <div class="text-danger"></div>
                        </div>    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add-task-type">Add Type</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>