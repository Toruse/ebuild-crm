<tr>
    <td>
        {{ $user->id }}
    </td>
    <td>
        {{$user->full_name}}
    </td>
    <td>
        @if ($user->profile)
            {{ $user->profile->email }}
        @else
            {{ $user->email }}
        @endif
    </td>
    <td>
        {{ $user->phone }}
    </td>
    <td>
        <a href="{{ route('users.send-new-accesses', ['user' => $user]) }}" class="send-new-accesses"><i class="fa fa-envelope-o fa-lg"></i></a>
        <a href="{{ route('user-setting.edit', ['user' => $user]) }}"><i class="fa fa-cog fa-lg"></i></a>
        <form class="delete-form" method="post" action="{{ route('users.destroy', ['user' => $user]) }}" style="display: inline">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button type="submit" class="text-warning button-bg-clear"><i class="fa fa-trash fa-lg"></i></button>
        </form>
    </td>
</tr>