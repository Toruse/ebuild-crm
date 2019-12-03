function callbackGeolocationSetPosition(position) {
    $('#latitude').val(position.coords.latitude);
    $('#longitude').val(position.coords.longitude);
}

$(function() {
    
});