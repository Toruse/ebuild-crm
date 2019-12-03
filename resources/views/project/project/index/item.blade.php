<a href="{{ route('projects.edit', ['project' => $project]) }}" data-id="{{$project->id}}">
    <div class="panel panel-default" style="background-color: {{ $project->color }}">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <strong style="color:white;">
                        {{ $project->customerFullName }} | {{ $project->typeName }}<br>
                    </strong>
                </div>
                <div class="col-md-2">
                    <form class="delete-form" method="post" action="{{ route('projects.destroy', ['project' => $project]) }}" style="display: inline">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
            
                        <button type="submit" class="button-bg-clear button-delete-project button-delete-project-style"><i class="fa fa-trash fa-lg"></i></button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <strong style="color:white;">
                        {{ $project->user_start_date }} - {{ $project->user_end_date }}
                    </strong>
                </div>
            </div>
        </div>
    </div>
</a>