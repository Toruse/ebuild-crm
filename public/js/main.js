function preloaderStart() {
    $.preloader.start({
        src : '/images/preloaders/sprites2.png',
        modal: false,
    });
}

function preloaderModalStart() {
    $.preloader.start({
        src : '/images/preloaders/sprites2.png',
        modal: true,
    });
}

function preloaderStop() {
    $.preloader.stop();
}

$(function() {
    $(document).on('submit', '.delete-form', function( e ) {
        return confirm('Do you really want to delete this entry?');
    });

    $(document).on('click', '.delete-button', function( e ) {
        if (confirm('Do you really want to delete this entry?')) {
            $(this).parents('tr').remove();
            var action = $(this).attr('href');
            var csrf = $('meta[name="csrf-token"]').attr('content');
    
            preloaderStart();
        
            $.ajax({
                url: action,
                method: 'post',
                data: {_method: 'DELETE'},
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
            }).done(function(data) {
                preloaderStop();
            }).fail(function(xhr) {
                preloaderStop();
            });
        }
        return false;
    });

    $('#user_time').val(moment(new Date()).format("YYYY-MM-DD HH:mm:ss"));

    $(document).on('submit', '.submit-attach-last-time', function(e) {
        $('#user_time').val(moment(new Date()).format("YYYY-MM-DD HH:mm:ss"));
    });

    $(document).on('click', '#button-click-logout', function(e) {
        preloaderModalStart();
        var action = $(this).attr('href');

        $.ajax({
            url: action,
            method: 'GET',
        }).done(function(data) {
            if (data.html) {
                $('.list-tasks-today').html(data.html);
                $('#logoutFormModal').modal('show');
            } else {
                $('#logoutFormModal form').submit();
            }
            preloaderStop();
        }).fail(function(xhr) {
            $('#logoutFormModal form').submit();
            preloaderStop();
        });

        e.preventDefault();
    });
});