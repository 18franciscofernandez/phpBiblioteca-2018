<?php
	require_once('conectar.php');
	$conexion=conectar();

class Login{
	public function validar($email, $password){
		session_start();
		$consulta="SELECT * FROM usuarios WHERE email = '$email' and clave = '$password'";
		$conexion=conectar();
		$dato=mysqli_query($conexion, $consulta);
		if ((mysqli_num_rows($dato)) == 1) {
			$row=mysqli_fetch_array($dato);
			if ($row['rol'] == 'LECTOR') {
				$_SESSION['estado'] = "in";
			} else {
				$_SESSION['estado'] = "bibliotecario";
			}
			$nombre = $row['nombre'];
			$apellido = $row['apellido'];
			$email = $row['email'];
			$id = $row['id'];
			setcookie("nom", $nombre);
			setcookie("ap", $apellido);
			setcookie("email", $email);
			setcookie("id", $id);
            header('Location: index.php');
		} else {
			throw new Exception("Datos incorrectos");
			
		}
	}

}




?>