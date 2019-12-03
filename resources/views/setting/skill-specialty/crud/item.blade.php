<tr>
    <td>
        {{ $skillSpecialty->id }}
    </td>
    <td>
        <a href="{{ route('skill-specialtys.edit', ['skillSpecialty' => $skillSpecialty]) }}">
            {{ $skillSpecialty->name }}
        </a>
    </td>
    <td>
        <a href="{{ route('skill-specialtys.edit', ['skillSpecialty' => $skillSpecialty]) }}"><i class="fa fa-edit fa-lg"></i></a>
        <a href="{{ route('skill-specialtys.show', ['skillSpecialty' => $skillSpecialty]) }}"><i class="fa fa-eye fa-lg"></i></a>
        <form class="delete-form" method="post" action="{{ route('skill-specialtys.destroy', ['skillSpecialty' => $skillSpecialty]) }}" style="display: inline">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button skillSpecialty="submit" class="text-warning button-bg-clear"><i class="fa fa-trash fa-lg"></i></button>
        </form>
    </td>
</tr>