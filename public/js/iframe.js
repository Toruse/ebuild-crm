$(function() {
    if (modal == 2) {
        $('.close-iframe').click(function(e) { 
            window.parent.$('#iframeSchedule').modal('hide');
            return false;
        }); 
    }
});