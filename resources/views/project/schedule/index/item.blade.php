<tr>
    <td>
        {{ $schedule->id }}
    </td>
    <td>
        {{ $schedule->title }}
    </td>
    <td>
        {{ $schedule->description }}
    </td>
    <td>
        <a href="{{ route('schedules.edit', ['schedule' => $schedule]) }}"><i class="fa fa-edit fa-lg"></i></a>
        <a href="{{ route('schedules.show', ['schedule' => $schedule]) }}"><i class="fa fa-eye fa-lg"></i></a>
        <form class="delete-form" method="post" action="{{ route('schedules.destroy', ['schedule' => $schedule]) }}" style="display: inline">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button type="submit" class="text-warning button-bg-clear"><i class="fa fa-trash fa-lg"></i></button>
        </form>
    </td>
</tr>