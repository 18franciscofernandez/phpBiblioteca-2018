<?php
	require_once('conectar.php');
	$conexion=conectar();
	$id_operacion = $_POST['id_op'];
	$insertarUpdate = "UPDATE operaciones SET ultimo_estado = 'DEVUELTO' WHERE operaciones.id = '$id_operacion'";
	if (mysqli_query($conexion, $insertarUpdate)) {
		echo "<script>
                                    alert('El libro ha sido DEVUELTO correctamente!');
                                    window.location= 'bibliotecario_logueado.php'
                              </script>";
	} else { echo "<script>
    					alert('El libro no ha podido DEVOLVERSE por algún motivo, intente nuevamente.');
    					window.location= 'bibliotecario_logueado.php'
                              </script>";	}
?>