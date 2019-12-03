   @can('isProjectManager')
      <li><a href="{{ route('projects') }}">Projects</a></li>
      <li><a href="{{ route('customers.index') }}">Contacts</a></li>
   @endcan

   @can('isAdmin')
      <li><a href="{{ route('projects') }}">Projects</a></li>
      <li><a href="{{ route('customers.index') }}">Contacts</a></li>
      <li><a href="{{ route('settings') }}">Settings</a></li>
   @endcan    