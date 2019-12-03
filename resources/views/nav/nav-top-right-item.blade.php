<li class="info-notification">
    <a href="#" data-action="{{ route('notify.mark-viewed', ['notification' => $notification]) }}" class="on-click-mark-notify">
        <h4>{{ $notification->data['subject'] }}</h4>
        <p>{{ $notification->data['message'] }}</p>
    </a>
</li>
<li role="separator" class="divider"></li>
