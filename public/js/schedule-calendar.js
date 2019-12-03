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

    $('.calendar-edit').fullCalendar({
        defaultDate: defaultDate,
        editable: true,
        header: header,
        events: events,
        eventClick: function(event) {
            if (event.id) {
                $('.edit-task-schedule[data-id="'+event.id+'"]').trigger('click');
                return false;
            }
        },
        dayClick: function(date, jsEvent, view) {
            $('[data-target="#addScheduleTask"]').trigger('click');
            $('#addScheduleTask input[name="start_date"]').val(date.format('DD MMMM YYYY'));
            $('#addScheduleTask input[name="end_date"]').val(date.format('DD MMMM YYYY'));
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
                }
            });
        },
    });
});