function clock() {
    var time = new Date();
    var hr = time.getHours();
    var min = time.getMinutes();
    var sec = time.getSeconds();
    var ampm = " PM ";
    if (hr < 12) {
        ampm = " AM ";
    }
    if (hr > 12) {
        hr -= 12;
    }
    if (hr < 10) {
        hr = " " + hr;
    }
    if (min < 10) {
        min = "0" + min;
    }
    if (sec < 10) {
        sec = "0" + sec;
    }
    $("#time_lbl").html(hr + ":" + min + ":" + sec + "<small>" + ampm  + "</small>");
    setTimeout("clock()", 1000);
}

function getDTRTime(){
    var time = new Date();
    var hr = time.getHours();
    var min = time.getMinutes();
    var sec = time.getSeconds();
    var ampm = " PM ";
    if (hr < 12) {
        ampm = " AM ";
    }
    if (hr > 12) {
        hr -= 12;
    }
    if (hr < 10) {
        hr = " " + hr;
    }
    if (min < 10) {
        min = "0" + min;
    }
    if (sec < 10) {
        sec = "0" + sec;
    }

    var form_data = {
        hr : hr,
        min : min,
        ampm : ampm
    };

    return form_data;
}
window.onload = clock;