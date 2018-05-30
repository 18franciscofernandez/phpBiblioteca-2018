<!DOCTYPE>
<html>
<head>
	<title>Usuario: bibliotecario</title>
</head>
	<link type="text/css" rel="stylesheet" href="CSS/estilo.css">
	<script type="text/javascript" src="JS/miscript.js"></script>
<body>
	<div class="top">
		<div class="sesion">
			<span id="userDerecha">Usuario logueado: Bibliotecario</span><a href="./index.php">Cerrar sesion</a>
		</div>
        <div id="encabezado">
    	   <div class="image">
        	<img src="img/libros.jpg">
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
            	<button type="button" id="butBusc">Buscar</button>
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
        		<tr>
        			<td>
        				<a class="titulo" href="./perfil_libro.php">El libro de la vida</a>
        			</td>
        			<td>
        				<a class="titulo" href="./perfl_autor.php">Francisco Fern&aacute;ndez</a>
        			</td>
        			<td>
        				<a class="titulo" href="./perfil_usuario.php">Mart&iacute;n Mozo</a>
        			</td>
        			<td>
        				<span id="estadoLibro">Reservado</span>
        			</td>
        			<td>
        				<p>15/4/2018</p>
        			</td>
        			<td>
        				<button type="button" id="butBusc" onload="relenarCampo()">
        				</button>
        			</td>
        		</tr>
        		<tr>
        			<td>
        				<a class="titulo" href="./perfil_libro.php">Advanced develop on PHP</a>
        			</td>
        			<td>
        				<a class="titulo" href="./perfl_autor.php">Francisco Fern&aacute;ndez</a>
        			</td>
        			<td>
        				<a class="titulo" href="./perfil_usuario.php">Mart&iacute;n Mozo</a>
        			</td>
        			<td>
        				<p>Prestado</p>
        			</td>
        			<td>
        				<p>1/3/2018</p>
        			</td>
        			<td>
        				<button type="button" id="butBusc">
        					Devolver
        				</button>
        			</td>
        		</tr>
        		<tr>
        			<td>
        				<a class="titulo" href="./perfil_libro.php">Professional PHP Design Patterns</a>
        			</td>
        			<td>
        				<a class="titulo" href="./perfl_autor.php">Aaron Saray</a>
        			</td>
        			<td>
        				<a class="titulo" href="./perfil_usuario.php">Francisco Fern&aacute;ndez</a>
        			</td>
        			<td>
        				<p>Devuelto</p>
        			</td>
        			<td>
        				<p>10/4/2018</p>
        			</td>
        			<td>
        				<button style="" type="button" id="butBusc">
        					Prestar
        				</button>
        			</td>
        		</tr>
        		<tr>
        			<td>
        				<a class="titulo" href="./perfil_libro.php">El libro de la vida</a>
        			</td>
        			<td>
        				<a class="titulo" href="./perfl_autor.php">Francisco Fern&aacute;ndez</a>
        			</td>
        			<td>
        				<a class="titulo" href="./perfil_usuario.php">Mart&iacute;n Mozo</a>
        			</td>
        			<td>
        				<p>Reservado</p>
        			</td>
        			<td>
        				<p>15/4/2018</p>
        			</td>
        			<td>
        				<button type="button" id="butBusc">
        					Prestar
        				</button>
        			</td>
        		</tr>

		</div>
	</div>

</body>
</html>