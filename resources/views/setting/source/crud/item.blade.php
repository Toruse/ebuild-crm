<tr>
    <td>
        {{ $source->id }}
    </td>
    <td>
        <a href="{{ route('sources.edit', ['source' => $source]) }}">
            {{ $source->name }}
        </a>
    </td>
    <td>
        <a href="{{ route('sources.edit', ['source' => $source]) }}"><i class="fa fa-edit fa-lg"></i></a>
        <a href="{{ route('sources.show', ['source' => $source]) }}"><i class="fa fa-eye fa-lg"></i></a>
        <form class="delete-form" method="post" action="{{ route('sources.destroy', ['source' => $source]) }}" style="display: inline">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button type="submit" class="text-warning button-bg-clear"><i class="fa fa-trash fa-lg"></i></button>
        </form>
    </td>
</tr>