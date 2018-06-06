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
			$email = $row['email'];
			setcookie("nom", $nombre);
			setcookie("ap", $apellido);
			setcookie("email", $email);
            header('Location: index.php');
		} else {
          	echo "<script type=\"text/javascript\">alert(\"Se ha cerrado sesión correctamente.\");</script>";
            header('Location: iniciar_sesion.php');
		}
	}

}




?>