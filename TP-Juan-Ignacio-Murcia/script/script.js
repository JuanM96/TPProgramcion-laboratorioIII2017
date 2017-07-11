$(document).ready(function (){
    $("#inicio").click(function (){
        $('#right_block').text("");
    });
    $("#estado").click(function (){

    });
    $("#entVehiculo").click(function (){
        $('#right_block').html("<form><div class='form-group'><label for='dueño_id' class='control-label'>Dueño del auto</label><input type='text' class='form-control' id='dueño_id' name='dueño' placeholder='Nombre del dueño del auto'>    </div>    <div class='form-group'>        <label for='patente_id' class='control-label'>Patente</label>        <input type='text' class='form-control' id='patente_id' name='patente' placeholder='####-000'></div><div class='form-group'><label for='marca_id' class='control-label'>Marca</label><input type='text' class='form-control' id='marca_id' name='marca' placeholder='Marca'></div><div class='form-group'><label for='color_id' class='control-label'>Color</label><input type='text' class='form-control' id='color_id' name='color' placeholder='Color'></div><div class='form-group'><label for='numBox_id' class='control-label'>Num box</label><input type='text' class='form-control' id='numBox_id' name='NumBox' placeholder='Numero de box'></div><div class='form-group'><label for='numPiso_id' class='control-label'>Num Piso</label><input type='text' class='form-control' id='numPiso_id' name='NumPiso' placeholder='Numero de Piso'></div><div class='form-group'><label for='dni_id' class='control-label'>Dni Empleado</label><input type='text' class='form-control' id='dni_id' name='dni' placeholder='Dni'></div><div class='form-group'><button type='submit' class='btn btn-primary' onclick = estacionar()>Estacionar</button></div></form>");        
    });
    $("#salVehiculo").click(function (){
        
    });
    $("#admin").click(function (){
        
    });
    $("#administrar").click(function (){
        
    });
    $("#altaEmpleado").click(function (){
        
    });
    $("#bajaEmpelado").click(function (){
        
    });
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
    var date = Digital.getDate();
    var days = ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"];
    var day = days[Digital.getDay()];
    
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
    myclock = "<b>"+ date +" - "+ day +"<br>"+ hours + ":" + minutes + ":" +
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

function estacionar(){
    var datapost= {
        dueño: $('#dueño_id').val(),
        patente: $('#patente_id').val(),
        marca: $('#marca_id').val(),
        color: $('#color_id').val(),
        numBox: $('#numBox_id').val(),
        numPiso: $('#numPiso_id').val(),
        dni: $('#dni_id').val()
    }
    $.ajax({
        url: 'php/operacion/iniciar',
        type: 'POST',
        data: datapost,
        dataType: 'json',
    })
    .done(function(data){
        alert(data['resultado'])
    })
    .fail(function(data){
        alert("ERROR AL ESTACIONAR"+data)
    })
}