<!DOCTYPE>
<html>
<head>
	<title>
		Biblioteca
	</title>
	<link type="text/css" rel="stylesheet" href="CSS/estilo.css">
	<script type="text/javascript" src="JS/miscript.js"></script>
</head>
<body>
	<div id="encabezado2" class="top">
		<div class="sesion2">
 			<a href="./iniciar_sesion.php">Iniciar sesion</a>
 		</div>
		<a href="./index.php"><img src="IMG/libros.jpg"></a>
	</div>
 	<div id="margenGeneral">
		<h1 id="tituloLibro">Registro de lector</h1>
		<div class="inpForm">
			<form onsubmit="return validar(this)" id="formRegistrarse" action="registrar-usuario.php" method="POST">
				<div>
					<label>Nombre:</label>
				</div>
				<div>
					<input type="text" name="nombre"><span class="error" id="errorNombre"></span>
					<!-- A LA CLASE "error" DEBO PONERLE ESTILOS DE ERROR -->
				</div>
				<div>
					<label>Apellido:</label>
				</div>
				<div>
					<input type="text" name="apellido"><span class="error" id="errorApellido"></span>
				</div>
				<div>
					<label>Foto:</label>
				</div>
				<div>
					<input type="file" name="img">
				</div>
				<div>
					<label>Email:</label>
				</div>
				<div>
					<input type="email" name="mail"><span class="error" id="errorEmail"></span>
				</div>
				<div>
					<label>Clave:</label>
				</div>
				<div>
					<input type="password" name="clave"><span class="error" id="errorClave"></span>
				</div>
				<div>
					<label>Confirmacion de la clave:</label>
				</div>
				<div>
					<input type="password" name="clave2"><span class="error" id="errorClave2"></span>
				</div>
				<div id="botonRegistro">
					<input type="submit" name="Registrarse" value="Registrarse">
				</div>
			</form>
		</div>
	</div>
</body>
</html>