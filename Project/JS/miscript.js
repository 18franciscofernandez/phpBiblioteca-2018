function validar(form) {
	/*.	var nombre = document.getElementById('nombre').value;  otra manera
	de traerme los datos. Deberia ponerle un id a cada input para obtener su valor.*/
	valor=true;
	if ((/^[a-zA-Z() ]+$/.test(form.nombre.value))==false) {
		document.getElementById("errorNombre").innerHTML="El nombre ingresado solo debe poseer alfanumericos.";
		valor=false;
	} else {
		document.getElementById("errorNombre").innerHTML="";
	}
	if ((/^[a-zA-Z() ]+$/.test(form.apellido.value))==false) {
		document.getElementById("errorApellido").innerHTML="El apellido ingresado solo debe poseer alfanumericos.";
		valor=false;
	} else {
		document.getElementById("errorApellido").innerHTML="";
	}
	if ((/\S+@\S+/.test(form.mail.value))==false) {
		document.getElementById("errorEmail").innerHTML="El email ingresado no es valido.";
		valor=false;
	} else {
		document.getElementById("errorEmail").innerHTML="";
	}
	if ((/[0-9\$@\!#]/.test(form.clave.value) && /[A-Z]/.test(form.clave.value) && /[a-z]/.test(form.clave.value) && form.clave.value.length > 5)==false) {
		document.getElementById("errorClave").innerHTML="La contrase&ntilde;a ingresada posee menos de 6 caracteres y/o debe poseer al menos un numero y un símbolo.";
		valor=false;
	} else {
		document.getElementById("errorClave").innerHTML="";
	}
	if (form.clave.value!=form.clave2.value) {
		document.getElementById("errorClave2").innerHTML="Las contrase&ntilde;as ingresadas no son iguales."
		valor=false;
	} else {
		document.getElementById("errorClave2").innerHTML="";
	}
	return valor;
}

function validarInicio(form){
	val=true;
	if ((/\S+@\S+/.test(form.usuario.value))==false) {
		document.getElementById("errorUsuario").innerHTML="El usuario ingresado no es valido. Ingrese su mail";
		val=false;
	} else {
		document.getElementById("errorUsuario").innerHTML="";
	}
	if ((/^.{6,}$/).test(form.contra.value)==false) {
		document.getElementById("errorContra").innerHTML="La contrase&ntilde;a ingresada es inv&aacute;lida.";
		val=false;
	} else {
		document.getElementById("errorContra").innerHTML="";
	}
	return val;

}
