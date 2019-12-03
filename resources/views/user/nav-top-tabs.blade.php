<ul class="nav nav-tabs">
    <li role="presentation"{!! Route::is('customers.*') ? ' class="active"' : '' !!}><a href="{{ route('customers.index') }}">Clients</a></li>
    <li role="presentation"{!! Route::is('vendors.*') ? ' class="active"' : '' !!}><a href="{{ route('vendors.index') }}">Vendors</a></li>
    <li role="presentation"{!! Route::is('sales-associates.*') ? ' class="active"' : '' !!}><a href="{{ route('sales-associates.index') }}">Sales Associates</a></li>
    <li role="presentation"{!! Route::is('contractors.*') ? ' class="active"' : '' !!}><a href="{{ route('contractors.index') }}">Contractors</a></li>
    <li role="presentation"{!! Route::is('project-managers.*') ? ' class="active"' : '' !!}><a href="{{ route('project-managers.index') }}">Project Managers</a></li>
    @can('isAdmin')
        <li role="presentation"{!! Route::is('admins.*') ? ' class="active"' : '' !!}><a href="{{ route('admins.index') }}">Admins</a></li>
        <li role="presentation"{!! Route::is('users.*') ? ' class="active"' : '' !!}><a href="{{ route('users.index') }}">Users</a></li>
    @endcan
</ul>