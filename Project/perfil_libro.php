<!DOCTYPE>
<html>
<head>
  <?php 
    require_once("conectar.php");
    $conexion=conectar();
    if ($_GET['libroID']=='') {
      header('location: index.php');
      die();
    }
    $strId=$_GET['libroID'];
    $consultaLibro="SELECT titulo, cantidad, descripcion, autores_id FROM libros WHERE id=".$strId;
    $resultLibro=mysqli_query($conexion,$consultaLibro);
    $libro=mysqli_fetch_array($resultLibro);
    $consultaAutor="SELECT nombre, apellido FROM autores WHERE autores.id=".$libro['autores_id'];

        $operaciones_reservado = "SELECT ultimo_estado FROM operaciones WHERE libros_id = '".$strId."' and ultimo_estado = 'RESERVADO'";
        $operaciones_prestado = "SELECT ultimo_estado FROM operaciones WHERE libros_id = '".$strId."' and ultimo_estado = 'PRESTADO'";
        $consultaReservados = mysqli_query($conexion, $operaciones_reservado);
        $stringReservados= "";
        if ((mysqli_num_rows($consultaReservados)) != 0) {
            $stringReservados= " - ".(mysqli_num_rows($consultaReservados))." reservado/s";
        }
        $consultaPrestados = mysqli_query($conexion, $operaciones_prestado);
        $stringPrestados= "";
        if ((mysqli_num_rows($consultaPrestados)) != 0) {
            $stringPrestados= " - ".(mysqli_num_rows($consultaPrestados))." prestado/s";
        }
        $stringDisponibles = "";
        if (($libro['cantidad']-((mysqli_num_rows($consultaReservados))+(mysqli_num_rows($consultaPrestados)))) > 0 ) {
            $stringDisponibles = ($libro['cantidad']-((mysqli_num_rows($consultaReservados))+(mysqli_num_rows($consultaPrestados))))." disponible/s";
        }

        $resultAutor=mysqli_query($conexion,$consultaAutor);
        $autor=mysqli_fetch_array($resultAutor);
          session_start();
            /* CHEQUEO SI TENGO SETEADA LA VARIABLE DE SESIÓN PARA MOSTRAR ABAJO LA SECCIÓN INDICADA */
            if (!(isset($_SESSION['estado']))) {
              $_SESSION['estado'] = "out";
            }
      ?>
  <title><?php echo $libro['titulo']; ?></title>
  <link rel="stylesheet" type="text/css" href="CSS/estilo.css">
</head>
<body>
  <div>

  <?php
  /*+
    +
    + ------------------ENCABEZADO USUARIO NO REGISTRADO--------------------------------
  */
  if ($_SESSION['estado'] == 'out') { ?>
    <div id="encabezado2" class="top">
      <div class="sesion2">
        <a href="./registro_lector.php">Registrarse</a>
        <a href="./iniciar_sesion.php">Iniciar sesion</a>
      </div>
      <a href="./index.php" title="Ir al inicio"><img src="IMG/libros.jpg"></a>
    </div>
  <?php
    /*+
    +
    + ------------------ENCABEZADO REGISTRADO--------------------------------
  */

  } elseif ($_SESSION['estado'] == 'in') {
    
  ?>
    <div class="top">
    <div class="sesion">
      <span id="userDerecha">
        <a href="perfil_usuario.php">Usuario logueado: <?php echo $_COOKIE['nom']; ?> <?php echo $_COOKIE['ap'] ?></a>
        </span>
      <a href="logout.php">Cerrar sesion</a>
    </div>
        <div id="encabezado">
            <div class="image">
                <a href="./index.php" title="Ir al inicio"><img src="img/libros.jpg"></a>
            </div>
        </div>    
    </div>
    <?php
    /*+
    +
    + ------------------ENCABEZADO bibliotecario--------------------------------
  */
    } elseif ($_SESSION['estado'] == 'bibliotecario') {
     ?>
    <div class="top">
    <div class="sesion">
      <span id="userDerecha">
        <a href="bibliotecario_logueado.php">Bibliotecario logueado: <?php echo $_COOKIE['nom']; ?> <?php echo $_COOKIE['ap'] ?></a>
        </span>
      <a href="logout.php">Cerrar sesion</a>
    </div>
        <div id="encabezado">
            <div class="image">
                <a href="./index.php" title="Ir al inicio"><img src="img/libros.jpg"></a>
            </div>
        </div>    
    </div>
    <?php } ?>


    <div id="margenGeneral">
      <h1 id="fontTitulo"><?php echo $libro['titulo'] ?></h1>
<!-- CODIGO PARA TRAERME LA FOTO !-->

      <div class="presentacionLibro">
        <img src="mostrar-imagen.php?idLibro=<?php echo $strId ?>">
        <div class="datosDeLibro">
          <p class="datoEnCursiva"><span class="datoEnNegrita">Autor: </span><?php echo $autor['nombre']." ".$autor['apellido'] ?></p><br>
          <p class="datoEnCursiva"><span class="datoEnNegrita">Ejemplares: </span><?php echo $libro['cantidad'] ?> <?php echo "(".$stringDisponibles.$stringPrestados.$stringReservados.")"; ?></p><br>
          <p class="datoEnNegrita">Descripcion:</p><br>
        </div>
        <p class="parrafoLibro"><?php echo $libro['descripcion'] ?></p>
      </div>
    </div>
  </div>
</body>
</html>
