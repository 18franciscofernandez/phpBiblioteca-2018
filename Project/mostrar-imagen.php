<?php 

$id= $_GET['idLibro'];
require_once("conectar.php");
$conexion= conectar();

$consulta = "SELECT portada FROM libros WHERE id =".$id;
$result = mysqli_query($conexion, $consulta);
$row = mysqli_fetch_array($result);

mysqli_close($conexion);

header("Content-type: " .'jpg');
echo $row['portada'];

?>