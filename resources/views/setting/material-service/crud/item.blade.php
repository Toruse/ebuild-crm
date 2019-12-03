<tr>
    <td>
        {{ $materialService->id }}
    </td>
    <td>
        <a href="{{ route('material-services.edit', ['materialService' => $materialService]) }}">
            {{ $materialService->name }}
        </a>
    </td>
    <td>
        <a href="{{ route('material-services.edit', ['materialService' => $materialService]) }}"><i class="fa fa-edit fa-lg"></i></a>
        <a href="{{ route('material-services.show', ['materialService' => $materialService]) }}"><i class="fa fa-eye fa-lg"></i></a>
        <form class="delete-form" method="post" action="{{ route('material-services.destroy', ['materialService' => $materialService]) }}" style="display: inline">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button materialService="submit" class="text-warning button-bg-clear"><i class="fa fa-trash fa-lg"></i></button>
        </form>
    </td>
</tr>