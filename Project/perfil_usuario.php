<!DOCTYPE>
<html>
<?php 
	require_once('conectar.php');
	$conexion=conectar();
	$consulta="SELECT * FROM usuarios WHERE email = '".$_COOKIE['email']."'";
	$usuario = mysqli_query($conexion, $consulta);
	$row = mysqli_fetch_array($usuario);
    session_start();

    $consulta_operaciones = "SELECT operaciones.id, operaciones.ultimo_estado, operaciones.fecha_ultima_modificacion, operaciones.libros_id AS id_libro, libros.titulo, libros.autores_id, autores.id AS id_autor, autores.nombre, autores.apellido FROM operaciones inner join libros ON operaciones.libros_id = libros.id inner join autores ON autores.id = libros.autores_id WHERE operaciones.lector_id = '".$row['id']."' ORDER BY operaciones.fecha_ultima_modificacion";
    $dato = mysqli_query($conexion, $consulta_operaciones);
?>
<head>
	<title>
		Perfil - Biblioteca
	</title>
	<link rel="stylesheet" type="text/css" href="CSS/estilo.css">
	<script type="text/javascript" src="JS/miscript.js"></script>
</head>
<body>
	<div id="encabezado2" class="top">
		<div class="sesion2">
 			<a href="logout.php">Cerrar Sesion</a>
 		</div>
		<a href="./index.php"><img src="IMG/libros.jpg"></a>
	</div>
	<div id="margenGeneral">
		<h1 id="fontTitulo">Mi perfil:</h1>
		<div class="presentacionLibro">
			<img id="imgPerfilAutor" src="mostrar-imagen_perfil.php?email=<?php echo $row['email'];?>">
			<div class="datosDeLibro">
				<p class="datoEnCursiva"><span class="datoEnNegrita">Nombre: </span>
					<?php echo $row['nombre']; ?>
				</p><br>
				<p class="datoEnCursiva"><span class="datoEnNegrita">Apellido: </span>
					<?php echo $row['apellido']; ?>
				</p><br>
				<p class="datoEnCursiva"><span class="datoEnNegrita">Email: </span>
					<?php echo $row['email']; ?>
				</p><br>
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
				<?php 
					while ($row_ops = mysqli_fetch_array($dato)) {

				?>
				<tr>
					<td>
						<img src="mostrar-imagen.php?idLibro=<?php echo $row_ops['id_libro'];?>">
					</td>
					<td>
						<a href="perfil_libro.php?libroID=<?php echo $row_ops['id_libro'];?>"><?php echo $row_ops['titulo'] ?></a>
					</td>
					<td>
						<a href="perfil_autor.php?autorID=<?php echo $row_ops['id_autor']; ?>"><?php echo $row_ops['apellido'].", ".$row_ops['nombre']; ?></a>
					</td>
					<td>
						<p><?php echo $row_ops['ultimo_estado'] ?></p>
					</td>
					<td>
						<p><?php echo $row_ops['fecha_ultima_modificacion'] ?></p>
					</td>
				</tr>
				<?php } ?>  
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

