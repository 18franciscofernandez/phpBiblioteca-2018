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
    session_start();
    if (($_SESSION['estado']=="in") or ($_SESSION['estado'] =="out") or (!isset($_SESSION['estado']))){
        header('location: index.php');
        die();
    }
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
        	<a href="./index.php" title="Ir al inicio"><img src="IMG/libros.jpg"></a>
      	</div>
      <div class="formulario">
        <form method="GET" action="bibliotecario_logueado.php">
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
            	<input type="date" name="fechaDesde">
            </div>
            <div class="inpForm">
            	<p id="margFecha">Fecha hasta:</p>
            	<input type="date" name="fechaHasta">
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

                    $consultaGrande = "SELECT libros.id AS id_libro, libros.titulo AS titulo, autores.id AS id_autor, autores.nombre AS autor_nombre, autores.apellido AS autor_apellido, usuarios.nombre AS user_nombre, usuarios.apellido AS user_apellido, operaciones.id AS id_operacion, operaciones.ultimo_estado AS ultimo_estado, operaciones.fecha_ultima_modificacion AS fecha FROM libros inner join operaciones ON libros.id = operaciones.libros_id inner join autores ON libros.autores_id = autores.id inner join usuarios ON operaciones.lector_id = usuarios.id WHERE 1=1";
                    $filtro="";
                    $filtro2="";
                    $filtro3="";
                    $filtro4="";
                    $filtro5="";
                    
                    if (!empty($_GET['tit'])) {
                        $filtro=" AND libros.titulo LIKE '%".$_GET['tit']."%'";
                    }
                    if (!empty($_GET['autor'])) {
                        $filtro2=" AND (autores.nombre LIKE '%".$_GET['autor']."%' OR autores.apellido LIKE '%".$_GET['autor']."%')";
                    } 
                    if (!empty($_GET['lector'])) {
                        $filtro3=" AND (usuarios.nombre LIKE '%".$_GET['lector']."%' OR usuarios.apellido LIKE '%".$_GET['lector']."%')";
                    }
                    if (!empty($_GET['fechaDesde'])) {
                        $filtro4=" AND operaciones.fecha_ultima_modificacion >='".$_GET['fechaDesde']."'";
                    }
                    if (!empty($_GET['fechaHasta'])) {
                        $filtro5=" AND operaciones.fecha_ultima_modificacion <='".$_GET['fechaHasta']."'";
                    }

                    $datosOperaciones = mysqli_query($conexion, $consultaGrande.$filtro.$filtro2.$filtro3.$filtro4.$filtro5);
                    $total_registros = mysqli_num_rows($datosOperaciones);
                    // Y AHORA SACO EL TOTAL DE PAGINAS EXISTENTES
                    $total_paginas = ceil($total_registros / $resultados_por_pagina);

                    $resultados = mysqli_query($conexion, $consultaGrande.$filtro.$filtro2.$filtro3.$filtro4.$filtro5." ORDER BY operaciones.fecha_ultima_modificacion DESC LIMIT $empezar_desde, $resultados_por_pagina");
                    while ($row = mysqli_fetch_array($resultados)) {

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
        if (!empty($_GET['tit'])) {
            $t="&tit=".$_GET['tit']."";
        }else{ $t=""; }
        if (!empty($_GET['autor'])) {
            $a="&autor=".$_GET['autor']."";
        }else{ $a=""; }
        if (!empty($_GET['lector'])) {
            $l="&lector=".$_GET['lector']."";
        }else{ $l=""; }
        if (!empty($_GET['fechaDesde'])) {
            $fD="&fechaDesde=".$_GET['fechaDesde']."";
        }else{ $fD=""; }
        if (!empty($_GET['fechaHasta'])) {
            $fH="&fechaHasta=".$_GET['fechaHasta']."";
        }else{ $fH=""; }

        if ((!empty($_GET['tit']))and(!empty($_GET['autor']))and(!empty($_GET['lector']))and(!empty($_GET['fechaDesde']))and(!empty($_GET['fechaHasta']))) {
            echo "<a href='?pagina=".$i.$t.$a.$l.$fD.$fH."'>".$i."</a> | ";
        }
    };

    ?>
    </div>
	</div>

</body>
</html>