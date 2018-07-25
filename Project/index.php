<!DOCTYPE>
<html>
      <?php
        require_once("conectar.php");
        $conexion= conectar();

        $resultados_por_pagina = 5;
        if (isset($_GET["pagina"])){
            $pagina = $_GET["pagina"];
        } else { //Si el GET de HTTP no está seteado, lleva a la primera página
          $pagina = 1;
        }
        // defino el numero 0 para empoezar a paginar multiplicando por la cantidad de resultados por pagina
        $empezar_desde = ($pagina-1) * $resultados_por_pagina;
        session_start();
        /* CHEQUEO SI TENGO SETEADA LA VARIABLE DE SESIÓN PARA MOSTRAR ABAJO LA SECCIÓN INDICADA */
        if (!(isset($_SESSION['estado']))) {
          $_SESSION['estado'] = "out";
        }
      ?>
<head>
  <meta charset="utf-8">
  <title>Biblioteca</title>
  <link type="text/css" rel="stylesheet" href="CSS/estilo.css">
  <script type="text/javascript" src="JS/miscript.js"></script>
</head>
<body>

  <?php
/* +
    +
     + --------- INDEX DE USUARIO LOGUEADO ------------- */


  if ($_SESSION['estado'] == 'in') { ?>
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
          <div class="formulario">
            <form action="index.php" method="get" >
              <fieldset>
                <legend>Refinar Busqueda:</legend>
                <div class="inpForm">
                  <input placeholder="Titulo" type="text" name="tit"></div>
                <div class="inpForm">
                  <input placeholder="Autor" type="text" name="autor">
                  <button type="submit" id="butBusc">Buscar</button>
                </div>
              </fieldset>
            </form>
          </div>
        </div>    
    </div>
  <div>
    <div>
      <h3>Catalogo de libros:</h3>
    </div>
    <div id="recuadroTabla">
      <table class="tabla">
        <tr>
          <th>Portada</th>
          <th>Titulo</th>
          <th>Autor</th>
          <th>Ejemplares</th>
          <th>Acci&oacute;n</th>
        </tr>
        <?php 
          $consulta="SELECT libros.id AS id_libro, libros.titulo, libros.cantidad, autores.id AS id_autor, autores.nombre, autores.apellido FROM libros inner join autores ON autores.id = libros.autores_id WHERE 1=1";
          $filtro="";
          $filtro2="";
          if ((!empty($_GET['tit'])) and (empty($_GET['autor']))) {
            $filtro=" and libros.titulo LIKE '%".$_GET['tit']."%'";
          } else {
              if ((!empty($_GET['autor'])) and (empty($_GET['tit']))) {
                  $filtro2=" and autores.nombre LIKE '%".$_GET['autor']."%' or autores.apellido LIKE '%".$_GET['autor']."%'";
              } elseif ((!empty($_GET['autor'])) and (!empty($_GET['tit']))) {
                    $filtro=" and libros.titulo LIKE '%".$_GET['tit']."%'";
                    $filtro2=" or autores.nombre LIKE '%".$_GET['autor']."%' or autores.apellido LIKE '%".$_GET['autor']."%'";
              }
          }
          /* el espacio antes del and es para que no se pegue la consulta */
          $dato=mysqli_query($conexion, $consulta.$filtro.$filtro2);
          /* en la variable $dato tengo el vector con la consulta y el filtro ingresado */

          // PARA LA PAGINACION AHORA SACO EL NUMERO DE REGISTROS QUE ME TRAJE
          $total_registros = mysqli_num_rows($dato);
          // Y AHORA SACO EL TOTAL DE PAGINAS EXISTENTES
          $total_paginas = ceil($total_registros / $resultados_por_pagina);

          $consulta_resultados = mysqli_query($conexion, $consulta.$filtro.$filtro2." ORDER BY libros.titulo ASC LIMIT $empezar_desde, $resultados_por_pagina");


          while ($row = mysqli_fetch_array($consulta_resultados)) {
            $operaciones_reservado = "SELECT ultimo_estado FROM operaciones WHERE libros_id = '".$row['id_libro']."' and ultimo_estado = 'RESERVADO'";
            $operaciones_prestado = "SELECT ultimo_estado FROM operaciones WHERE libros_id = '".$row['id_libro']."' and ultimo_estado = 'PRESTADO'";
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
            if (($row['cantidad']-((mysqli_num_rows($consultaReservados))+(mysqli_num_rows($consultaPrestados)))) > 0 ) {
                $stringDisponibles = ($row['cantidad']-((mysqli_num_rows($consultaReservados))+(mysqli_num_rows($consultaPrestados))))." disponible/s";
            }
          ?>
            <tr>
            <td>
              <img src="mostrar-imagen.php?idLibro=<?php echo $row['id_libro'];?>">
            </td>
            <td>
              <a href="perfil_libro.php?libroID=<?php echo $row['id_libro'];?>"><?php echo $row['titulo'] ?></a>
            </td>
            <td>
              <a href="perfil_autor.php?autorID=<?php echo $row['id_autor']; ?>"><?php echo $row['apellido'].", ".$row['nombre']; ?></a>
            </td>
            <td>
              <?php echo $row["cantidad"] ?> <?php echo "(".$stringDisponibles.$stringPrestados.$stringReservados.")"; ?>
            </td>
            <td>
                <?php 
                $consultaMisOperaciones = "SELECT * FROM operaciones WHERE lector_id = '".$_COOKIE['id']."' and ultimo_estado = 'PRESTADO' or ultimo_estado = 'RESERVADO'";
                $datosOps= mysqli_query($conexion, $consultaMisOperaciones);
                $reservadosMasPrestados = mysqli_num_rows($datosOps);
                if ((($row['cantidad']-((mysqli_num_rows($consultaReservados))+(mysqli_num_rows($consultaPrestados)))) > 0) and ($reservadosMasPrestados < 3) ) {
                ?>
                    <form action="reservar.php" method="POST">
                        <input type="hidden" name="user_email" value="<?php echo $_COOKIE['email']; ?>">
                        <input type="hidden" name="libro_id" value="<?php echo $row['id_libro']; ?>">
                        <div id="botonRegistro">
                            <input onclick="return confirm('¿Estas seguro que deseas reservar el libro?')" type="submit" name="Reservar" value="Reservar">
                        </div>
                    </form>
                <?php } elseif ($reservadosMasPrestados = 3) {
                ?>
                L&iacute;mite de operaciones alcanzado.
                <?php } 
                ?>
            </td>
            </tr>
            <?php } ?>  
      </table>
    </div>
    </div>
  <?php
  /*
    +
    +
    + ------------------------------- INDEX DE USUARIO BIBLIOTECARIO -------------------------------------- */ 
    } elseif ($_SESSION['estado'] == 'bibliotecario') {


  ?>
    <div class="top">
    <div class="sesion">
      <span id="userDerecha">
        <a href="bibliotecario_logueado.php" title="Perfil de bibliotecario - Control de operaciones">Bibliotecario logueado: <?php echo $_COOKIE['nom']; ?> <?php echo $_COOKIE['ap'] ?></a>
        </span>
      <a href="logout.php">Cerrar sesion</a>
    </div>
        <div id="encabezado">
            <div class="image">
                <a href="./index.php" title="Ir al inicio"><img src="img/libros.jpg"></a>
            </div>
          <div class="formulario">
            <form action="index.php" method="get" >
              <fieldset>
                <legend>Refinar Busqueda:</legend>
                <div class="inpForm">
                  <input placeholder="Titulo" type="text" name="tit"></div>
                <div class="inpForm">
                  <input placeholder="Autor" type="text" name="autor">
                  <button type="submit" id="butBusc">Buscar</button>
                </div>
              </fieldset>
            </form>
          </div>
        </div>    
    </div>
  <div>
    <div>
      <h3>Catalogo de libros:</h3>
    </div>
    <div id="recuadroTabla">
      <table class="tabla">
        <tr>
          <th>Portada</th>
          <th>Titulo</th>
          <th>Autor</th>
          <th>Ejemplares</th>
        </tr>
        <?php 
          $consulta="SELECT libros.id AS id_libro, libros.titulo, libros.cantidad, autores.id AS id_autor, autores.nombre, autores.apellido FROM libros inner join autores ON autores.id = libros.autores_id WHERE 1=1";
          $filtro="";
          $filtro2="";
          if ((!empty($_GET['tit'])) and (empty($_GET['autor']))) {
            $filtro=" and libros.titulo LIKE '%".$_GET['tit']."%'";
          } else {
              if ((!empty($_GET['autor'])) and (empty($_GET['tit']))) {
                  $filtro2=" and autores.nombre LIKE '%".$_GET['autor']."%' or autores.apellido LIKE '%".$_GET['autor']."%'";
              } elseif ((!empty($_GET['autor'])) and (!empty($_GET['tit']))) {
                    $filtro=" and libros.titulo LIKE '%".$_GET['tit']."%'";
                    $filtro2=" or autores.nombre LIKE '%".$_GET['autor']."%' or autores.apellido LIKE '%".$_GET['autor']."%'";
              }
          }
          /* el espacio antes del and es para que no se pegue la consulta */
          $dato=mysqli_query($conexion, $consulta.$filtro.$filtro2);
          /* en la variable $dato tengo el vector con la consulta y el filtro ingresado */

          // PARA LA PAGINACION AHORA SACO EL NUMERO DE REGISTROS QUE ME TRAJE
          $total_registros = mysqli_num_rows($dato);
          // Y AHORA SACO EL TOTAL DE PAGINAS EXISTENTES
          $total_paginas = ceil($total_registros / $resultados_por_pagina);

          $consulta_resultados = mysqli_query($conexion, $consulta.$filtro.$filtro2." ORDER BY libros.titulo ASC LIMIT $empezar_desde, $resultados_por_pagina");

          while ($row = mysqli_fetch_array($consulta_resultados)) {
            $operaciones_reservado = "SELECT ultimo_estado FROM operaciones WHERE libros_id = '".$row['id_libro']."' and ultimo_estado = 'RESERVADO'";
            $operaciones_prestado = "SELECT ultimo_estado FROM operaciones WHERE libros_id = '".$row['id_libro']."' and ultimo_estado = 'PRESTADO'";
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
            if (($row['cantidad']-((mysqli_num_rows($consultaReservados))+(mysqli_num_rows($consultaPrestados)))) > 0 ) {
                $stringDisponibles = ($row['cantidad']-((mysqli_num_rows($consultaReservados))+(mysqli_num_rows($consultaPrestados))))." disponible/s";
            }

          ?>
            <tr>
            <td>
              <img src="mostrar-imagen.php?idLibro=<?php echo $row['id_libro'];?>">
            </td>
            <td>
              <a href="perfil_libro.php?libroID=<?php echo $row['id_libro'];?>"><?php echo $row['titulo'] ?></a>
            </td>
            <td>
              <a href="perfil_autor.php?autorID=<?php echo $row['id_autor']; ?>"><?php echo $row['apellido'].", ".$row['nombre']; ?></a>
            </td>
            <td>
              <?php echo $row["cantidad"] ?> <?php echo "(".$stringDisponibles.$stringPrestados.$stringReservados.")"; ?>
            </td>
            </tr>
            <?php } ?>  
      </table>
    </div>
    </div>

  <?php
  /* +
    +
     + ------------------------------  INDEX DE USUARIO NO REGISTRADO ------------------------------------- */

  } else { ?>
      <div class="top">
        <div class="sesion">
          <a href="./registro_lector.php">Registrarse</a>
          <a href="./iniciar_sesion.php">Iniciar sesion</a>
        </div>
        <div id="encabezado">
            <div class="image">
                <a href="./index.php" title="Ir al inicio"><img src="img/libros.jpg"></a>
            </div>
          <div class="formulario">
            <form action="index.php" method="get" >
              <fieldset>
                <legend>Refinar Busqueda:</legend>
                <div class="inpForm">
                  <input placeholder="Titulo" type="text" name="tit"></div>
                <div class="inpForm">
                  <input placeholder="Autor" type="text" name="autor">
                  <button type="submit" id="butBusc">Buscar</button>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>

  <div>
    <div>
      <h3>Catalogo de libros:</h3>
    </div>
    <div id="recuadroTabla">
      <table class="tabla">
        <tr>
          <th>Portada</th>
          <th>Titulo</th>
          <th>Autor</th>
          <th>Ejemplares</th>
        </tr>
        <?php 
          $consulta="SELECT libros.id AS id_libro, libros.titulo, libros.cantidad, autores.id AS id_autor, autores.nombre, autores.apellido FROM libros inner join autores ON autores.id = libros.autores_id WHERE 1=1";
          $filtro="";
          $filtro2="";
          if ((!empty($_GET['tit'])) and (empty($_GET['autor']))) {
            $filtro=" and libros.titulo LIKE '%".$_GET['tit']."%'";
          } else {
              if ((!empty($_GET['autor'])) and (empty($_GET['tit']))) {
                  $filtro2=" and autores.nombre LIKE '%".$_GET['autor']."%' or autores.apellido LIKE '%".$_GET['autor']."%'";
              } elseif ((!empty($_GET['autor'])) and (!empty($_GET['tit']))) {
                    $filtro=" and libros.titulo LIKE '%".$_GET['tit']."%'";
                    $filtro2=" or autores.nombre LIKE '%".$_GET['autor']."%' or autores.apellido LIKE '%".$_GET['autor']."%'";
              }
          }
          /* el espacio antes del and es para que no se pegue la consulta */
          $dato=mysqli_query($conexion, $consulta.$filtro.$filtro2);
          /* en la variable $dato tengo el vector con la consulta y el filtro ingresado */

          // PARA LA PAGINACION AHORA SACO EL NUMERO DE REGISTROS QUE ME TRAJE
          $total_registros = mysqli_num_rows($dato);
          // Y AHORA SACO EL TOTAL DE PAGINAS EXISTENTES
          $total_paginas = ceil($total_registros / $resultados_por_pagina);

          $consulta_resultados = mysqli_query($conexion, $consulta.$filtro.$filtro2." ORDER BY libros.titulo ASC LIMIT $empezar_desde, $resultados_por_pagina");

          while ($row = mysqli_fetch_array($consulta_resultados)) {
            $operaciones_reservado = "SELECT ultimo_estado FROM operaciones WHERE libros_id = '".$row['id_libro']."' and ultimo_estado = 'RESERVADO'";
            $operaciones_prestado = "SELECT ultimo_estado FROM operaciones WHERE libros_id = '".$row['id_libro']."' and ultimo_estado = 'PRESTADO'";
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
            if (($row['cantidad']-((mysqli_num_rows($consultaReservados))+(mysqli_num_rows($consultaPrestados)))) > 0 ) {
                $stringDisponibles = ($row['cantidad']-((mysqli_num_rows($consultaReservados))+(mysqli_num_rows($consultaPrestados))))." disponible/s";
            }

          ?>
            <tr>
            <td>
              <img src="mostrar-imagen.php?idLibro=<?php echo $row['id_libro'];?>">
            </td>
            <td>
              <a href="perfil_libro.php?libroID=<?php echo $row['id_libro'];?>"><?php echo $row['titulo'] ?></a>
            </td>
            <td>
              <a href="perfil_autor.php?autorID=<?php echo $row['id_autor']; ?>"><?php echo $row['apellido'].", ".$row['nombre']; ?></a>
            </td>
            <td>
              <?php echo $row["cantidad"] ?> <?php echo "(".$stringDisponibles.$stringPrestados.$stringReservados.")"; ?>
            </td>
            </tr>
            <?php } ?>  
      </table>
    </div>
  </div>
  <?php } ?>
  <div class="paginado">
    <?php 

    for ($i=1; $i<=$total_paginas; $i++) {
      if ((!empty($_GET['tit'])) and (!empty($_GET['autor']))) {
        echo "<a href='?pagina=".$i."&tit=".$_GET['tit']."&autor=".$_GET['autor']."'>".$i."</a> | ";
      } elseif ((empty($_GET['tit'])) and (!empty($_GET['autor']))) {
        echo "<a href='?pagina=".$i."&autor=".$_GET['autor']."'>".$i."</a> | ";
      } elseif ((!empty($_GET['tit'])) and (empty($_GET['autor']))) {
        echo "<a href='?pagina=".$i."&tit=".$_GET['tit']."'>".$i."</a> | ";
      }
    };

    ?>
    </div>
  </div>
</body>
</html>