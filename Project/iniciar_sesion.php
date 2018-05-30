<!DOCTYPE>
<html>
<head>
  <title>
    Iniciar sesion - Biblioteca
  </title>
  <link type="text/css" rel="stylesheet" href="CSS/estilo.css">
  <script type="text/javascript" src="JS/miscript.js"></script>
</head>
<body>
    <div id="encabezado2" class="top">
        <div class="sesion2">
            <a href="./registro_lector.php">Registrarse</a>
        </div>
        <a href="./index.php"><img src="IMG/libros.jpg"></a>
    </div>
    <div id="margenGeneral">
        <h1 id="tituloLibro">Iniciar sesi&oacute;n</h1>
        <div class="inpForm">
            <form onsubmit="return validarInicio(this)" id="formRegistrarse">
                <div>
                    <label>Nombre de usuario:</label>
                </div>
                <div>
                    <input type="text" name="usuario" placeholder="Ingrese su email"><span class="error" id="errorUsuario"></span>  
                </div>
                <div>
                    <label>Contrase&ntilde;a</label>
                </div>
                <div>
                    <input type="password" name="contra" placeholder="Ingrese su contrase&ntilde;a"><span class="error" id="errorContra"></span>
                </div>
                <div id="botonRegistro"> 
                    <a href="perfil_usuario.php"><input type="submit" name="iniciarSesion" value="Iniciar sesi&oacute;n"></a>    
                </div>  
            </form>    
        </div>
    </div>
</body>
</html>