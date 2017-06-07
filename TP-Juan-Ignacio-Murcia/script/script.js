$(document).ready(function (){
    /*$("#inicio").onclick(function (){
        
    });
    $("#estado").onclick(function (){
        
    });
    $("#entVehiculo").onclick(function (){
        
    });
    $("#salVehiculo").onclick(function (){
        
    });
    $("#admin").onclick(function (){
        
    });
    $("#administrar").onclick(function (){
        
    });
    $("#altaEmpleado").onclick(function (){
        
    });
    $("#bajaEmpelado").onclick(function (){
        
    });*/
    window.onload=show5
});
function show5()
{
    // Reloj digital para web javascript
    // Copyright 2015 bloguero-ec.
    // Usese cómo mas le convenga no elimine estas líneas (http://www.bloguero-ec.com)
    if (!document.layers && !document.all && !document.getElementById)
        return

    var Digital = new Date()
    var hours = Digital.getHours()
    var minutes = Digital.getMinutes()
    var seconds = Digital.getSeconds()

    var dn = "PM"
    if (hours < 12)
        dn = "AM"
    if (hours > 12)
        hours = hours - 12
    if (hours == 0)
        hours = 12

    if (minutes <= 9)
        minutes = "0" + minutes
    if (seconds <= 9)
        seconds = "0" + seconds
    //change font size here to your desire
    myclock = "<b>" + hours + ":" + minutes + ":" +
        seconds + " " + dn + "</b>"
    if (document.layers) {
        document.layers.liveclock.document.write(myclock)
        document.layers.liveclock.document.close()
    } else if (document.all)
        liveclock.innerHTML = myclock
    else if (document.getElementById)
        document.getElementById("liveclock").innerHTML = myclock
    setTimeout("show5()", 1000)
}