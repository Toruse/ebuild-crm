<div class="modal fade" id="addProjectType" tabindex="-1" role="dialog" aria-labelledby="addProjectTypeLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open([
                'route' => 'project-types.addquick',
                'method' => 'post',
            ]) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addProjectTypeLabel">Create New Type</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', '', [
                                'class' => 'form-control',
                                'id' => 'project-type-name'
                            ]) !!}
                            <div class="text-danger"></div>
                        </div>    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add-type">Add Type</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>