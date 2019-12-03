<tr>
    <td>
        {{ $type->id }}
    </td>
    <td>
        <a href="{{ route('task-types.edit', ['type' => $type]) }}">
            {{ $type->name }}
        </a>
    </td>
    <td>
        <a href="{{ route('task-types.edit', ['type' => $type]) }}"><i class="fa fa-edit fa-lg"></i></a>
        <a href="{{ route('task-types.show', ['type' => $type]) }}"><i class="fa fa-eye fa-lg"></i></a>
        <form class="delete-form" method="post" action="{{ route('task-types.destroy', ['type' => $type]) }}" style="display: inline">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button type="submit" class="text-warning button-bg-clear"><i class="fa fa-trash fa-lg"></i></button>
        </form>
    </td>
</tr>