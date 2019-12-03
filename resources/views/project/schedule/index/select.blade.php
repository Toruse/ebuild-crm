<tr>
    <td>
        {!! Form::radio('schedule', $schedule->id) !!}
    </td>
    <td>
        {{ $schedule->title }}
    </td>
    <td>
        {{ $schedule->description }}
    </td>
    <td>
        <a href="{{ route('schedules.edit', ['schedule' => $schedule, 'modal' => '2']) }}" class="model-edit-schedule"><i class="fa fa-edit fa-lg"></i></a>
        <a href="{{ route('schedules.destroy', ['schedule' => $schedule, 'modal' => '2']) }}" class="text-warning delete-button"><i class="fa fa-trash fa-lg"></i></a>
    </td>
</tr>