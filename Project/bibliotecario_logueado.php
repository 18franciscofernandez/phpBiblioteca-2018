<!DOCTYPE>
<html>
<?php
    require_once('conectar.php');
    $conexion=conectar();

    $resultados_por_pagina = 5;
    if (isset($_GET["pagina"])){
        $pagina = $_GET["pagina"];
    } else { //Si el GET de HTTP no está seteado, lleva a la primera página
        $pagina = 1;
    }
    // defino el numero 0 para empoezar a paginar multiplicando por la cantidad de resultados por pagina
    $empezar_desde = ($pagina-1) * $resultados_por_pagina;

    $consultaGrande = "SELECT libros.id AS id_libro, libros.titulo AS titulo, autores.id AS id_autor, autores.nombre AS autor_nombre, autores.apellido AS autor_apellido, usuarios.nombre AS user_nombre, usuarios.apellido AS user_apellido, operaciones.id AS id_operacion, operaciones.ultimo_estado AS ultimo_estado, operaciones.fecha_ultima_modificacion AS fecha FROM libros inner join operaciones ON libros.id = operaciones.libros_id inner join autores ON libros.autores_id = autores.id inner join usuarios ON operaciones.lector_id = usuarios.id WHERE 1=1";
    $datosOperaciones = mysqli_query($conexion, $consultaGrande);
?>
<head>
	<title>Usuario: bibliotecario</title>
</head>
	<link type="text/css" rel="stylesheet" href="CSS/estilo.css">
	<script type="text/javascript" src="JS/miscript.js"></script>
<body>
	<div class="top">
		<div class="sesion">
			<span id="userDerecha">Usuario logueado: Bibliotecario</span><a href="logout.php">Cerrar Sesion</a>
		</div>
        <div id="encabezado">
    	   <div class="image">
        	<a href="./index.php"><img src="IMG/libros.jpg"></a>
      	</div>
      <div class="formulario">
        <form>
          <fieldset>
            <legend>Refinar Busqueda:</legend>
            <div class="inpForm">
            	<input placeholder="Titulo" type="text" name="tit"></div>
            <div class="inpForm">
              <input placeholder="Autor" type="text" name="autor">
            </div>
            <div class="inpForm">
            	<input placeholder="Lector" type="text" name="lector">
            </div>
            <div class="inpForm">
            	<p id="margFecha">Fecha desde:</p>
            	<input placeholder="Fecha desde:" type="date" name="fechaDesde">
            </div>
            <div class="inpForm">
            	<p id="margFecha">Fecha hasta:</p>
            	<input placeholder="Fecha desde:" type="date" name="fechaHasta">
            	<button type="submit" id="butBusc">Buscar</button>
            </div>                       
          </fieldset>
        </form>
      </div>
    </div>		
	</div>
	<div>
		<div>
			<h3>Operaciones:</h3>
		</div>
		<div id="recuadroTabla">
      		<table class="tabla">
        		<tr>
          			<th>Titulo</th>
          			<th>Autor</th>
          			<th>Lector</th>
          			<th>Estado</th>
          			<th>Fecha</th>
          			<th>Acci&oacute;n</th>
        		</tr>
                <?php
                    $filtro="";
                    if (!empty($_GET['tit'])) {
                        $filtro=" and libros.titulo LIKE '%".$_GET['tit']."%'";
                    }
                    $filtro2="";
                    if (!empty($_GET['autor'])) {
                        $filtro2=" or autores.nombre LIKE '%".$_GET['autor']."%' or autores.apellido LIKE '%".$_GET['autor']."%'";
                    }
                    $filtro3="";
                    if (!empty($_GET['lector'])) {
                        $filtro3=" or usuarios.nombre LIKE '%".$_GET['lector']."%' or usuarios.apellido LIKE '%".$_GET['lector']."%'";
                    }
                    $filtro4="";
                    if ((!empty($_GET['fechaDesde'])) & (!empty($_GET['fechaHasta']))) {
                        $filtro4=" or operaciones.fecha_ultima_modificacion BETWEEN '%".$_GET['fechaDesde']."%' AND '%".$_GET['fechaHasta']."%'";
                    }

                    $total_registros = mysqli_num_rows($datosOperaciones);
                    // Y AHORA SACO EL TOTAL DE PAGINAS EXISTENTES
                    $total_paginas = ceil($total_registros / $resultados_por_pagina);

                    $datosOperaciones = mysqli_query($conexion, $consultaGrande.$filtro.$filtro2.$filtro3.$filtro4." ORDER BY operaciones.fecha_ultima_modificacion DESC LIMIT $empezar_desde, $resultados_por_pagina");
                    while ($row = mysqli_fetch_array($datosOperaciones)) {
                ?>
        		<tr>
        			<td>
        				<a href="perfil_libro.php?libroID=<?php echo $row['id_libro'];?>"><?php echo $row['titulo'] ?></a>
        			</td>
        			<td>
        				<a href="perfil_autor.php?autorID=<?php echo $row['id_autor']; ?>"><?php echo $row['autor_apellido'].", ".$row['autor_nombre']; ?></a>
        			</td>
        			<td>
        				<?php echo $row['user_apellido'].", ".$row['user_nombre']; ?>
        			</td>
        			<td>
        				<span id="estadoLibro"><?php echo $row['ultimo_estado'] ?></span>
        			</td>
        			<td>
        				<p><?php echo $row['fecha'] ?></p>
        			</td>
        			<td>
        				<?php 
                            if ($row['ultimo_estado'] == 'RESERVADO') {
                        ?>
                            <form action="prestar.php" method="POST">
                                <input type="hidden" name="id_op" value="<?php echo $row['id_operacion']; ?>">
                                <div id="botonRegistro">
                                    <input onclick="return confirm('¿Estas seguro que deseas PRESTAR este libro?')" type="submit" name="Prestar" value="Prestar">
                                </div>
                            </form>
                        <?php
                            } elseif ($row['ultimo_estado'] == 'PRESTADO') {
                        ?>
                            <form action="devolver.php" method="POST">
                                <input type="hidden" name="id_op" value="<?php echo $row['id_operacion']; ?>">
                                <div id="botonRegistro">
                                    <input onclick="return confirm('¿Estas seguro que deseas DEVOLVER este libro?')" type="submit" name="Devolver" value="Devolver">
                                </div>
                            </form>
                        <?php
                            } else {
                        ?>
                        <?php
                            }
                        ?>
        			</td>
        		</tr>
                <?php } ?>
            </table>
		</div>
        <div class="paginado">
    <?php 

    for ($i=1; $i<=$total_paginas; $i++) {
      echo "<a href='?pagina=".$i."'>".$i."</a> | ";
    };

    ?>
    </div>
	</div>

</body>
</html>