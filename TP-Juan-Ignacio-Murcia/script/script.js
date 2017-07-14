$(document).ready(function (){
    $("#inicio").click(function (){
        $('#right_block').text("");
    });
	
	$("#login_submit").click(function(){
		var dataPost = {
		dni: $('#dni_id').val(),
		password: $('#password_id').val()
		}
		$.ajax({
		url: 'php/ingreso/logIn',
		type: 'POST',
		data: dataPost,
		dataType: 'json'
		})
		.done(function(data){
			if(data.logIn == true){
				localStorage.setItem('token', data.token);
				if(data.empleado.admin == "1"){
					$('#adminLi').css('display', 'initial');
					$('#login_block').html("<div align='center' style='color: #FED045;background: #CC0000;margin: 0px 58px 5px 18px;border-radius: 5px;border: 25px solid #303d66;'>¡BIENVENIDO/A., <b><span style='color: white;text-transform: uppercase;'>"+data.empleado.nombre+"</span>!<button type='button' name='login_submit' id='login_submit' onclick = logOut()>SALIR</button></b></div>")
				}
				else{
					$('#login_block').html("<div align='center' style='color: #FED045;background: #374572;margin: 0px 58px 5px 18px;border-radius: 5px;border: 25px solid #303d66;'>¡BIENVENIDO/A., <b><span style='color: white;text-transform: uppercase;'>"+data.empleado.nombre+"</span>!<button type='button' name='login_submit' id='login_submit' onclick = logOut()>SALIR</button></b></div>")
				}
			}
			else{
				alert("Usuario o Contraseña incorrectos")
			}
		})
		.fail(function(data){
			alert("ERROR AL INGRESAR INTENTE MAS TARDE")
		})
	});
	
    $("#estado").click(function(){
		var cantLugares = 20;
		var cantPisos = 3;
		var boxLibres;
		var boxOcupados;
		var auxPatente;
		$.ajax({
			url: 'php/box/traerBoxesOcupadas',
			type: 'GET',
			headers: { token : localStorage.getItem('token')},
			dataType: 'json',
		})
		.done(function(data){
			boxOcupados = data;
		})
		.fail(function(data){
			ret = "ERROR DE SISTEMA NO ESTA LOGEADO";
			$('#right_block').html(ret);
		})
		$.ajax({
			url: 'php/box/traerBoxesLibres',
			type: 'GET',
			headers: { token : localStorage.getItem('token')},
			dataType: 'json',
		})
		.done(function(data){
			boxLibres = data;
			var libre = false;
			var ret = "<div><table>";
			for (var i = 0; i < cantPisos; i++) {
				ret += "<th>Piso Numero "+(i+1)+"</th><tr>";
				for (var j = 1; j <= cantLugares; j++) {
					for (var k = 0; k < boxLibres[i].boxesLibres.length ; k++) {
						if(j == boxLibres[i].boxesLibres[k]){
							//alert("PISO: "+(i+1)+" - Lugar: "+j+" - Libre: "+boxLibres[i].boxesLibres[k]);
							libre = true;
							//console.log(boxLibres[i].boxesLibres[k] + " - PISO NUM -> "+(i+1));
							break;
						}
					}
					if(j == 11){
						ret +="</tr><tr>"
					}
					if(libre == false){
						for (var l = 0; l < boxOcupados.length; l++) {
							if(boxOcupados[l].id == j.toString() && boxOcupados[l].piso == ((i+1).toString())){
								auxPatente = boxOcupados[l].patente;
							}
						}
						ret += "<td><img src='img/BoxOcupado.png' width='80' height='80' onclick=alert('"+auxPatente+"')>"+j+"</td>";
						
					}
					else{
						ret += "<td><img src='img/BoxLibre.png' width='80' height='80'>"+j+"</td>";
						libre = false;
					}
					
				}
				ret +="</tr>";
			}
			ret += "</div></table>";
			$('#right_block').html(ret);
		})
		.fail(function(data){
			ret = "ERROR DE SISTEMA NO ESTA LOGEADO";
			$('#right_block').html(ret);
		})

	});
	
    $("#entVehiculo").click(function (){
        $('#right_block').html("<form><div class='form-group'><label for='dueño_id' class='control-label'>Dueño del auto</label><input type='text' class='form-control' id='dueño_id' name='dueño' placeholder='Nombre del dueño del auto'>    </div>    <div class='form-group'>        <label for='patente_id' class='control-label'>Patente</label>        <input type='text' class='form-control' id='patente_id' name='patente' placeholder='####-000'></div><div class='form-group'><label for='marca_id' class='control-label'>Marca</label><input type='text' class='form-control' id='marca_id' name='marca' placeholder='Marca'></div><div class='form-group'><label for='color_id' class='control-label'>Color</label><input type='text' class='form-control' id='color_id' name='color' placeholder='Color'></div><div class='form-group'><label for='numBox_id' class='control-label'>Num box</label><input type='text' class='form-control' id='numBox_id' name='NumBox' placeholder='Numero de box'></div><div class='form-group'><label for='numPiso_id' class='control-label'>Num Piso</label><input type='text' class='form-control' id='numPiso_id' name='NumPiso' placeholder='Numero de Piso'></div><div class='form-group'><label for='dni_id' class='control-label'>Dni Empleado</label><input type='text' class='form-control' id='dni_id' name='dni' placeholder='Dni'></div><div class='form-group'><button type='button' class='btn btn-primary' onclick = estacionar()>Estacionar</button></div></form>");        
    });
    $("#salVehiculo").click(function (){
        $('#right_block').html("<form><div class='form-group'><label for='patente_id' class='control-label'>Patente</label><input type='text' class='form-control' id='patente_id' name='patente' placeholder='Patente (AAAA-000)'></div><div class='form-group'><button type='button' class='btn btn-primary' onclick = cobrar()>Cobrar</button></div></form>")
    });
    $("#altaEmpleado").click(function (){
        $('#right_block').html("<form><div class='form-group'><label for='nombre_id' class='control-label'>Nombre</label><input type='text' class='form-control' id='nombre_id' name='nombre' placeholder='Nombre Del Empleado'>    </div>    <div class='form-group'><label for='apellido_id' class='control-label'>Apellido</label><input type='text' class='form-control' id='apellido_id' name='apellido' placeholder='Ingrese el Apellido del Empleado'></div><div class='form-group'>        <label for='email_id' class='control-label'>email</label>        <input type='text' class='form-control' id='email_id' name='email' placeholder='Ingrese el Email del Empleado'></div><div class='form-group'><label for='dni_id' class='control-label'>DNI</label><input type='text' class='form-control' id='dni_id' name='dni' placeholder='DNI'></div><div class='form-group'><label for='password_id' class='control-label'>Password</label><input type='password' class='form-control' id='password_id' name='Password' placeholder='Ingrese Una Contraseña'></div><div class='form-group'><label for='admin_id' class='control-label'>El Empleado es administrador?</label><input type='text' class='form-control' id='admin_id' name='Administrador' placeholder='1 (si) / 0 (no)'></div><div class='form-group'><label for='suspendido_id' class='control-label'>El Empleado esta suspendido?</label><input type='text' class='form-control' id='suspendido_id' name='Suspendido' placeholder='1 (si) / 0 (no)'></div><div class='form-group'><button type='button' class='btn btn-primary' onclick = altaEmpleado()>Okey</button></div></form>");
    });
    $("#bajaEmpelado").click(function (){
        $('#right_block').html("<form><div class='form-group'><label for='dni_id' class='control-label'>DNI</label><input type='text' class='form-control' id='dni_id' name='dni' placeholder='DNI'></div><div class='form-group'><button type='button' class='btn btn-primary' onclick = bajaEmpleado()>Despedir</button></div></form>")
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
		duenio:$('#dueño_id').val(),
		patente:$('#patente_id').val(),
		marca:$('#marca_id').val(),
		color:$('#color_id').val(),
		idBox:$('#numBox_id').val(),
		idPiso:$('#numPiso_id').val(),
		dni:$('#dni_id').val()
    }
    $.ajax({
        url: 'php/operacion/iniciar',
        type: 'POST',
		headers: { token : localStorage.getItem('token')},
        data: datapost,
        dataType: 'json',
    })
    .done(function(data){
        alert(data.resultado)
    })
    .fail(function(data){
        alert("ERROR AL ESTACIONAR")
    })
}
function cobrar(){
	$.ajax({
        url: 'php/operacion/finalizar',
        type: 'POST',
		headers: { token : localStorage.getItem('token')},
        data: { patente: $('#patente_id').val() },
        dataType: 'json',
    })
    .done(function(data){
		if(data.costo == 0){
			alert("Precio:"+Math.round(Math.random()*170))
		}
		else{
			alert("Precio:"+data.costo)
		}
    })
    .fail(function(data){
        alert("ERROR AL COBRAR"+data)
    })
}
function altaEmpleado(){
    var datapost= {
		nombre:$('#nombre_id').val(),
		apellido:$('#apellido_id').val(),
		email:$('#email_id').val(),
		dni:$('#dni_id').val(),
		password:$('#password_id').val(),
		admin:$('#admin_id').val(),
		suspendido:$('#suspendido_id').val()
    }
    $.ajax({
        url: 'php/empleado/alta',
        type: 'POST',
		headers: { token : localStorage.getItem('token')},
        data: datapost,
        dataType: 'json',
    })
    .done(function(data){
        alert(data.respuesta)
    })
    .fail(function(data){
        alert("ERROR AL INSCRIBIR")
    })
}
function bajaEmpleado(){
	$.ajax({
        url: 'php/empleado/baja',
        type: 'POST',
		headers: { token : localStorage.getItem('token')},
        data: { dni: $('#dni_id').val() },
        dataType: 'json',
    })
    .done(function(data){
		alert(data.resultado);
    })
    .fail(function(data){
        alert("ERROR AL DESPEDIR")
    })
}
function logOut(){
	localStorage.removeItem("token");
	window.location.reload();
}
