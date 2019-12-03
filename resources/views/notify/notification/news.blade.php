@if ($notifications->isNotEmpty())
    <div class="dropdown-toolbar text-right">
        <a href="#" data-action="{{ route('notify.mark-all-viewed') }}" class="on-click-mark-all">Mark all as viewed</a>
    </div>
    @each('nav.nav-top-right-item', $notifications, 'notification')
@else 
    <li class="notification-empty text-center">
        <a href="#">
            No notifications
        </a>
    </li>
@endif