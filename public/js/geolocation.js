$(function() {
    var watchID = null;

    function getPosition(position) {
        if (typeof (callbackGeolocationSetPosition ) === "function"){
            callbackGeolocationSetPosition(position); 
        }
    }

    function showPosition(position) {
        getPosition(position);
    }

    function watchPosition(position) {
        getPosition(position);
    }

    function errorPosition (error){
        console.warn(`ERROR(${error.code}): ${error.message}`);
    }

    function getLocation() {
        try {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, errorPosition);
                watchID = navigator.geolocation.watchPosition(watchPosition, errorPosition);
            }
        } catch (e) {

        }
    }  

    getLocation();
});