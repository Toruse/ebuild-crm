<div class="modal fade" id="logoutFormModal" tabindex="-1" role="dialog" aria-labelledby="logoutFormModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="logoutFormModalLabel">Tasks accomplished today</h4>
        </div>
        <div class="modal-body">
            {!! Form::open([
                'route' => 'logout',
                'method' => 'POST',
                'class' => 'submit-attach-last-time'
            ]) !!}
            {!! Form::hidden('user_time', null, [
                'id' => 'user_time',
            ]) !!}
            <div class="row">
                <div class="col-lg-12 bg-primary">
                    <h5>
                        Write notes to the tasks you have been working on.
                    </h5>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12 list-tasks-today">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-right">
                    {!! Form::submit('Logout',[
                        'class' => 'btn btn-success'
                    ]) !!}
                </div>
            </div>
            {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>