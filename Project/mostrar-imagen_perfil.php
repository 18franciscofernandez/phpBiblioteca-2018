<?php 

$id= $_GET['email'];
require_once("conectar.php");
$conexion= conectar();

$consulta = "SELECT foto FROM usuarios WHERE email ='".$id."'";
$result = mysqli_query($conexion, $consulta);
$row = mysqli_fetch_array($result);

mysqli_close($conexion);

header("Content-type: " .'jpg');
echo $row['foto'];

?>