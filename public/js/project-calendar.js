function addTaskToCalendar(event) {
    $('.calendar-edit').fullCalendar('renderEvent', event, true);
}

function addTasksToCalendar(events) {
    $('.calendar-edit').fullCalendar('renderEvents', events, true);
}

function updateTaskCalendar(event) {
    $('.calendar-edit').fullCalendar('removeEvents', event.id);
    $('.calendar-edit').fullCalendar('renderEvent', event);
}

function removeTaskCalendar(event) {
    $('.calendar-edit').fullCalendar('removeEvents', event.id);
}

$(function() {
    var header = {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
    }

    $('#indexSchedule').on('shown.bs.modal', function (e) {
        $('#indexSchedule').find('iframe').attr('src', function () { 
            return $(this)[0].src; 
        });
    });

    $('.calendar').fullCalendar({
        editable: true,
        header: header,
        events: events,
        dayClick: function(date, jsEvent, view) {
            window.location.href = $('.btn-add-project').attr('href') + '?selectdate='+date.format('DD MMMM YYYY');
        },
        eventDrop: function(event, delta) {
            $.ajax({
                url: event.data.urlEventDrop,
                method: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    start_date: event.start.format(),
                    end_date: event.end.format()
                },
                dataType: 'json'
            }).done(function(data) {
                if (data.status == 'ok') {
                    $('a[data-id="'+event.id+'"]').replaceWith(data.htmlUpdateProject);
                }
            });
        },
        eventResize: function(event, delta) {
            $.ajax({
                url: event.data.urlEventResize,
                method: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    start_date: event.start.format(),
                    end_date: event.end.format()
                },
                dataType: 'json'
            }).done(function(data) {
                if (data.status == 'ok') {
                    $('a[data-id="'+event.id+'"]').replaceWith(data.htmlUpdateProject);
                }
            });
        },
    });

    $('.calendar-edit').fullCalendar({
        editable: true,
        header: header,
        events: events,
        eventClick: function(event) {
            if (event.id) {
                $('.edit-task-project[data-id="'+event.id+'"]').trigger('click');
                return false;
            }
        },
        dayClick: function(date, jsEvent, view) {
            $('[data-target="#addTask"]').trigger('click');
            $('#addTask input[name="start_date"]').val(date.format('DD MMMM YYYY'));
            $('#addTask input[name="end_date"]').val(date.format('DD MMMM YYYY'));
            $(".datepicker").datepicker("update");
        },
        eventDrop: function(event, delta) {
            $.ajax({
                url: event.data.urlEventDrop,
                method: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    start_date: event.start.format(),
                    end_date: event.end.format()
                },
                dataType: 'json'
            }).done(function(data) {
                if (data.status == 'ok') {
                    $('.task-index tbody input[value="'+event.id+'"]').parents('tr').replaceWith(data.htmlChangeTask);
                    $('.show-project').html(data.htmlInfoProject);
                }
            });
        },
        eventResize: function(event, delta) {
            $.ajax({
                url: event.data.urlEventResize,
                method: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    start_date: event.start.format(),
                    end_date: event.end.format()
                },
                dataType: 'json'
            }).done(function(data) {
                if (data.status == 'ok') {
                    $('.task-index tbody input[value="'+event.id+'"]').parents('tr').replaceWith(data.htmlChangeTask);
                    $('.show-project').html(data.htmlInfoProject);
                }
            });
        },
    });
});