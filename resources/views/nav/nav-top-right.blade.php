<li class="dropdown panel-info-notifications" data-action="{{ route('notify.news') }}">
    @if ($notifications->isNotEmpty())
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i data-count="{{ $notifications->count() }}" class="glyphicon glyphicon-bell notification-icon"></i>
        </a>
        <ul class="dropdown-menu">
            <div class="dropdown-toolbar text-right">
                <a href="#" data-action="{{ route('notify.mark-all-viewed') }}" class="on-click-mark-all">Mark all as viewed</a>
            </div>
            @each('nav.nav-top-right-item', $notifications, 'notification')
        </ul>
    @else 
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i data-count="" class="glyphicon glyphicon-bell"></i>
        </a>
        <ul class="dropdown-menu">
            <li class="notification-empty text-center">
                <a href="#">
                    No notifications
                </a>
            </li>
        </ul>    
    @endif
</li>
<div class="hidden">
    <div id="template-no-notification" class="hidden">
        <li class="notification-empty text-center">
            <a href="#">
                No notifications
            </a>
        </li>
    </div>    
</div>