function calendarUpdateProjects(events) {
    var calendar = $('.calendar');
    calendar.fullCalendar('clientEvents').forEach(function(el) {
        calendar.fullCalendar('removeEvents', el.id);
    });
    calendar.fullCalendar('renderEvents', events, true);
}

$(function() {
    var timerUpdateEvents = setInterval(function() {
        $.ajax({
            url: routeUpdateEvents,
            method: 'get',
            dataType: 'json'
        }).done(function(data) {
            if (data.status == 'ok') {
               calendarUpdateProjects(data.events);
            }
        });
    }, 15000);
  
    var header = {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
    }

    $('.calendar').fullCalendar({
        header: header,
        events: events,
    });
});