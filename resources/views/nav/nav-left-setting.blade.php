<div class="list-group">
    <a href="{{ route('sources.index') }}" class="list-group-item{{ isset($select) && $select=='sources'?' active':'' }}">Sources</a>
    <a href="{{ route('project-types.index') }}" class="list-group-item{{ isset($select) && $select=='project-types'?' active':'' }}">Project Types</a>
    <a href="{{ route('material-services.index') }}" class="list-group-item{{ isset($select) && $select=='material-services'?' active':'' }}">Material/Services</a>
    <a href="{{ route('skill-specialtys.index') }}" class="list-group-item{{ isset($select) && $select=='skill-specialtys'?' active':'' }}">Skill/Specialty</a>
    <a href="{{ route('schedules.index') }}" class="list-group-item{{ isset($select) && $select=='schedules'?' active':'' }}">Schedule Templates</a>
    <a href="{{ route('task-types.index') }}" class="list-group-item{{ isset($select) && $select=='task-types'?' active':'' }}">Task Types</a>
    <a href="{{ route('priceds.index') }}" class="list-group-item{{ Route::is('priceds.*')?' active':'' }}">Priced</a>
</div>
