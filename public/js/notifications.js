$(function() {
    function clearAllNotifications() {
        $('.panel-info-notifications .dropdown-menu').html($('#template-no-notification').html());
        $(".panel-info-notifications i[data-count]").removeClass('notification-icon');
        $(".panel-info-notifications i[data-count]").attr('data-count', 0);
    }

    $(document).on('click', '.on-click-mark-all', function(e) {
        var self = $(this);

        $.ajax({
            url: self.data('action'),
            method: 'get',
            dataType: 'json'
        }).done(function(data) {
            if (data.status == 'ok') {
                clearAllNotifications();
            }
        });

        e.stopPropagation();
    });

    $(document).on('click', '.on-click-mark-notify', function(e) {
        var self = $(this);

        $.ajax({
            url: self.data('action'),
            method: 'get',
            dataType: 'json'
        }).done(function(data) {
            if (data.status == 'ok') {
                var delLi = $(self).parents('li.info-notification');
                delLi.slideUp("normal", function() {
                    $(this).next('li').remove();
                    $(this).remove();
                    var count = parseInt($(".panel-info-notifications i[data-count]").attr('data-count'));
                    count--;
                    if (count>0) {
                        $(".panel-info-notifications i[data-count]").attr('data-count', count);
                    } else {
                        clearAllNotifications();
                    }
                });
            }
        });
        e.stopPropagation();
    });

    var timerUpdateEvents = setInterval(function() {
        $.ajax({
            url: $('.panel-info-notifications').data('action'),
            method: 'get',
            dataType: 'json'
        }).done(function(data) {
            if (data.status == 'ok') {
                $('.panel-info-notifications .dropdown-menu').html(data.html);
                if (data.count>0) {
                    $(".panel-info-notifications i[data-count]").addClass('notification-icon');
                    $(".panel-info-notifications i[data-count]").attr('data-count', data.count);    
                } else {
                    $(".panel-info-notifications i[data-count]").removeClass('notification-icon');
                    $(".panel-info-notifications i[data-count]").attr('data-count', 0);    
                }
            }
        });
    }, 15000);
});