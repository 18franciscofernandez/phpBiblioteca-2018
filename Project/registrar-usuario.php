<?php 
	require_once("conectar.php");
    $conexion= conectar();
    $nombre=$_POST['nombre'];
    $apellido=$_POST['apellido'];
    $mail=$_POST['mail'];
    $clave=$_POST['clave'];
    $img=$_POST['img'];
    if (($nombre == '') or (!ctype_alpha($nombre))) {
    	echo "El nombre ingresado es vacío o posee car&aacute;cteeres inv&aacute;lidos";
    } else if (($apellido == '') or (!ctype_alpha($apellido))) {
    	echo "El apellido ingresado es vacío o posee car&aacute;cteeres inv&aacute;lidos";
    	} else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    		$buscarEmail="SELECT email FROM usuarios WHERE email = ".$mail;
    		$consulta=mysqli_query($conexion,$buscarEmail);
    		if (!$cantDatos=mysqli_num_rows($consulta)) {
    			echo "El email ya esta registrado.";
    		}
    	} else if (((strlen($clave))<6) or (ctype_upper($clave)) or (ctype_lower($clave)) or (preg_match('[0-9]',$clave)) or (!preg_match('@[!\@#.$%\?&\*\(\)_\-\+=]@', $clave))) {
    	
    			echo "La contrase&ntilde;a debe tener una combinacion de letras mayusculas, minusculas, al menos 6 caracteres y 1 signo o numero.";
    		} else if (empty($img)) {
    			echo "Debe ingresar una foto.";
    		} else {
    			$rol='LECTOR';
    			$datoSQL = "INSERT INTO usuarios (email,nombre,apellido,foto,clave,rol) VALUES ('$mail','$nombre','$apellido','$img','$clave','$rol')";
    			if (mysqli_query($conexion,$datoSQL)) { 
                        echo "<script>
                                    alert('El usuario ha sido registrado correctamente!');
                                    window.location= 'index.php'
                              </script>";
    			} else { echo "Ocurrio un error inesperado al registrarse, por favor intente nuevamente.";	}
    		}


 ?>