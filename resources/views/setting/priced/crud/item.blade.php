<tr>
    <td>
        {{ $priced->id }}
    </td>
    <td>
        <a href="{{ route('priceds.edit', ['priced' => $priced]) }}">
            {{ $priced->name }}
        </a>
    </td>
    <td>
        <a href="{{ route('priceds.edit', ['priced' => $priced]) }}"><i class="fa fa-edit fa-lg"></i></a>
        <a href="{{ route('priceds.show', ['priced' => $priced]) }}"><i class="fa fa-eye fa-lg"></i></a>
        <form class="delete-form" method="post" action="{{ route('priceds.destroy', ['priced' => $priced]) }}" style="display: inline">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button type="submit" class="text-warning button-bg-clear"><i class="fa fa-trash fa-lg"></i></button>
        </form>
    </td>
</tr>