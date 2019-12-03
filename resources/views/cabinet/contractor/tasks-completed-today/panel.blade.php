<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-{{ $task->id }}">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordionTasks" href="#collapse-{{ $task->id }}" aria-expanded="true" aria-controls="collapse-{{ $task->id }}">
                {{ $task->name_type }}
            </a>
        </h4>
    </div>
    <div id="collapse-{{ $task->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{ $task->id }}">
        <div class="panel-body">
            {!! Form::label('note', 'Note') !!}
            {!! Form::textArea('notes['.$task->id.']', '', ['class' => 'form-control', 'rows' => 5]) !!}
            <div class="text-danger"></div>
        </div>
    </div>
</div>