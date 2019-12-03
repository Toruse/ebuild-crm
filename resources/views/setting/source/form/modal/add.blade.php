<div class="modal fade" id="addSource" tabindex="-1" role="dialog" aria-labelledby="addSourceLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open([
                'route' => 'sources.addquick',
                'method' => 'post',
            ]) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addSourceLabel">Create New Source</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', '', [
                                'class' => 'form-control',
                                'id' => 'source-name'
                            ]) !!}
                            <div class="text-danger"></div>
                        </div>    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add-source">Add Source</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>