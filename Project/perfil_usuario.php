<!DOCTYPE>
<html>
<?php 
	require_once('conectar.php');
	$conexion=conectar();
	$consulta='SELECT ';
?>
<head>
	<title>
		nombre de usuario
	</title>
	<link rel="stylesheet" type="text/css" href="CSS/estilo.css">
	<script type="text/javascript" src="JS/miscript.js"></script>
</head>
<body>
	<div id="encabezado2" class="top">
		<div class="sesion2">
 			<a href="./iniciar_sesion.php">Cerrar Sesion</a>
 		</div>
		<a href="./index.php"><img src="IMG/libros.jpg"></a>
	</div>
	<div id="margenGeneral">
		<h1 id="fontTitulo">Usuario</h1>
		<div class="presentacionLibro">
			<img id="imgPerfilAutor" src="IMG/libroportada.jpg">
			<div class="datosDeLibro">
				<p class="datoEnCursiva"><span class="datoEnNegrita">Nombre: </span>Mozo, Martin.</p><br>
				<p class="datoEnCursiva"><span class="datoEnNegrita">Apellido: </span>3 (3 disponibles).</p><br>
				<p class="datoEnCursiva"><span class="datoEnNegrita">Email: </span>Gustavito@elMasCapito.com</p><br>
			</div>
		</div>
		<h2>Historial de operaciones</h2>
		<div id="recuadroTabla">
			<table class="tabla">
				<tr>
					<th>Portada</th>
					<th>Titulo</th>
					<th>Autor</th>
					<th>Estado</th>
					<th>Fecha</th>
				</tr>
				<tr>
					<td><img src="img/libroportada.jpg"></td>
					<td><a href="./perfil_libro.php">Viaje al centro de la tierra</a></td>
					<td><a href="./perfil_autor.php">Julio Verne</a></td>
					<td><p>Reservado</p></td>
					<td><p>09/06/1996</p></td>
				</tr>  
			</table>
		</div>
		<div id="buscPag">
			<a href="#"><< Primer pagina</a>
			<a href="#">< Pagina Anterior</a>
			<a href="#">Pagina Siguiente ></a>
			<a href="#">Ultima Pagina >></a>
		</div>
	</div>
</body>
</html>

