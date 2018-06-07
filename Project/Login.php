<?php
	require_once('conectar.php');
	$conexion=conectar();

class Login{
/*
	private function passwordCorrecta($datoIngresado, $datoReal){
		if ($datoIngresado != $datoReal) {
			throw new Exception("La contraseña ingresada es incorrecta.");
		}
	}

	private function emailExiste($cant){
		if($cant == 0){
			throw new Exception('El email no existe.');
		}
	}
*/

	public function validar($email, $password){
		session_start();
		$consulta="SELECT * FROM usuarios WHERE email = '$email' and clave = '$password'";
		$conexion=conectar();
		$dato=mysqli_query($conexion, $consulta);
		/*$datos=(mysqli_num_rows($dato));
		try {
			emailExiste($datos);
		} catch (Exception $e) {
			echo "Excepción capturada: ", $e->getMessage();
			header('Location: iniciar_sesion.php');
		}
		$row=mysqli_fetch_array($dato);
		try {
			passwordCorrecta($password, $row['clave']);
		} catch (Exception $e) {
			echo "Excepción capturada: ", $e->getMessage();
			header('Location: iniciar_sesion.php');
		}*/
		if ((mysqli_num_rows($dato)) == 1) {
			$_SESSION['estado'] = "in";
			$row=mysqli_fetch_array($dato);
			$nombre = $row['nombre'];
			$apellido = $row['apellido'];
			$email = $row['email'];
			$id = $row['id'];
			setcookie("nom", $nombre);
			setcookie("ap", $apellido);
			setcookie("email", $email);
			setcookie("id", $id);
            header('Location: index.php');
		}
	}

}




?>