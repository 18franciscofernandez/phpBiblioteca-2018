<?php
	require_once('conectar.php');
	$conexion=conectar();
	$email_usuario = $_POST['user_email'];
	$id_libro = $_POST['libro_id'];
	$consultaID = "SELECT * FROM usuarios WHERE email = '$email_usuario'";
	$dato = mysqli_query($conexion, $consultaID);
	$row = mysqli_fetch_array($dato);
	$id_user = $row['id'];
	$hoy = date("Y-m-d");
	$insertar_operacion = "INSERT INTO operaciones (ultimo_estado, fecha_ultima_modificacion, lector_id, libros_id) VALUES ('RESERVADO', '$hoy', '$id_user', '$id_libro')";
	if (mysqli_query($conexion, $insertar_operacion)) { 
                        echo "<script>
                                    alert('El libro ha sido reservado correctamente!');
                                    window.location= 'index.php'
                              </script>";
    } else { echo "<script>
    					alert('El libro no ha podido reservarse por algún motivo, intente nuevamente.');
    					window.location= 'index.php'
                              </script>";	}
?>