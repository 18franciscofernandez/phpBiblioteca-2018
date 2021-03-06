<!DOCTYPE>
<html>
  <?php
    require_once("conectar.php");
    $conexion= conectar();
    //hago la conexion con la DB
    if ($_GET['autorID']=='') {
      header('location: index.php');
      die();
    }
    $datoId= $_GET['autorID'];
    //pregunto si se paso una ID de autor por get y guardo el dato
    $resultados_por_pagina = 5;
    if (isset($_GET["pagina"])){
      $pagina = $_GET["pagina"];
    } else { //Si el GET de HTTP no está seteado, lleva a la primera página
      $pagina = 1;
    }
    // defino el numero 0 para empoezar a paginar multiplicando por la cantidad de resultados por pagina
    $empezar_desde = ($pagina-1) * $resultados_por_pagina;
    //empiezo con la peticion DB
    $consultaAutor="SELECT autores.nombre, autores.apellido FROM autores WHERE id=".$datoId;
    $resultAutor=mysqli_query($conexion, $consultaAutor);
    $autor=mysqli_fetch_array($resultAutor);
    $consultaLibro="SELECT libros.titulo, libros.cantidad, libros.id FROM libros WHERE libros.autores_id=".$datoId;
    $resultAux=mysqli_query($conexion, $consultaLibro);
    $total=mysqli_num_rows($resultAux);
    $total_paginas=ceil($total/$resultados_por_pagina);
    $resultLibro=mysqli_query($conexion,$consultaLibro." ORDER BY libros.titulo ASC LIMIT $empezar_desde, $resultados_por_pagina");
    session_start();
        /* CHEQUEO SI TENGO SETEADA LA VARIABLE DE SESIÓN PARA MOSTRAR ABAJO LA SECCIÓN INDICADA */
        if (!(isset($_SESSION['estado']))) {
          $_SESSION['estado'] = "out";
        }
  ?>
<head>
  <title><?php echo $autor['nombre'].' '.$autor['apellido'] ?> - Biblioteca</title>
  <link type="text/css" rel="stylesheet" href="CSS/estilo.css">
</head>
<body>

  <?php
  /*+
    +
    + ------------------ENCABEZADO USUARIO NO REGISTRADO--------------------------------
  */
  if ($_SESSION['estado'] == 'out') { ?>
  <div>
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
                <a href="./index.php"><img src="img/libros.jpg"></a>
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
                <a href="./index.php"><img src="img/libros.jpg"></a>
            </div>
        </div>    
    </div>
    <?php } ?>


    <div id="margenGeneral">
      <h1 id="fontTitulo"><?php echo $autor['nombre'].' '.$autor['apellido'] ?></h1>
      <div id="recuadroTabla">        
          <table class="tabla">
              <tr>
                  <th>Portada</th>
                  <th class="titulo">Titulo</th>
                  <th>Ejemplares</th>
              </tr>
              <?php 
              while ($libro=mysqli_fetch_array($resultLibro)) {
              ?>
              <tr>
                  <td><img src="mostrar-imagen.php?idLibro=<?php echo $libro['id']; ?>"></td>
                  <td><a class="titulo" href="./perfil_libro.php?libroID=<?php echo $libro['id'] ?>"><?=$libro["titulo"] ?></a></td>
                  <td><?=$libro["cantidad"] ?></td>
              </tr>
              <?php } ?>

            </table>
        </div>
      </div>
    <div class="paginado">
      <?php
        echo "| "; 
        for ($i=1; $i<=$total_paginas; $i++) {
          echo "<a href='?pagina=".$i."&autorID=".$datoId."'>".$i."</a> | ";
        };
      ?>
    </div>
  </div>
</body>
</html>