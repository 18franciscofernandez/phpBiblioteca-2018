<?php
	require_once('conectar.php');
	$conexion=conectar();

class Login{

	public function validar($email, $password){
		session_start();
		$consulta="SELECT * FROM usuarios WHERE email = '$email' and clave = '$password'";
		$conexion=conectar();
		$dato=mysqli_query($conexion, $consulta);
		$datos=(mysqli_num_rows($dato));
		if ($datos == 1) {
			$_SESSION['estado'] = "in";
			$row=mysqli_fetch_array($dato);
			$nombre = $row['nombre'];
			$apellido = $row['apellido'];
			setcookie("nom", $nombre);
			setcookie("ap", $apellido);
            header('Location: index.php');
		} else {
			setcookie("errorDatos", $error);
			$error = "Los datos de inicio de sesión son erróneos. Intente nuevamente.";
            header('Location: iniciar_sesion.php');
		}
	}

}




?>