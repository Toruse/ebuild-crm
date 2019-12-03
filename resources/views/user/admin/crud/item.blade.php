<tr>
    <td>
        {{ $user->id }}
    </td>
    <td>
        <a href="{{ route('admins.show', ['user' => $user]) }}">
            {{$user->full_name}}
        </a>
    </td>
    <td>
        <a href="{{ route('admins.show', ['user' => $user]) }}">
            @if ($user->profile && $user->profile->email)
                {{ $user->profile->email }}
            @else
                {{ $user->email }}
            @endif
        </a>
    </td>
    <td>
        {{ $user->phone }}
    </td>
    <td>
        <a href="{{ route('admins.edit', ['user' => $user]) }}"><i class="fa fa-edit fa-lg"></i></a>
        <a href="{{ route('admins.show', ['user' => $user]) }}"><i class="fa fa-eye fa-lg"></i></a>
        <a href="{{ route('users.send-new-accesses', ['user' => $user]) }}" class="send-new-accesses"><i class="fa fa-envelope-o fa-lg"></i></a>
        <a href="{{ route('user-setting.edit', ['user' => $user]) }}"><i class="fa fa-cog fa-lg"></i></a>
        <form class="delete-form" method="post" action="{{ route('admins.destroy', ['user' => $user]) }}" style="display: inline">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button type="submit" class="text-warning button-bg-clear"><i class="fa fa-trash fa-lg"></i></button>
        </form>
    </td>
</tr>