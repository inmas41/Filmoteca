<html>
<head>

<title>borrado</title>
</head>
<body>
    
<?php
include 'cabecera.php';
$id_pelicula=$_REQUEST['titulo'];

  include 'configuracion.php';
    
    $conexion = new mysqli(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD) or 
// Check connection or
    die("Problemas con la conexión");

mysqli_query($conexion,"delete from pelicula
						where id_pelicula=$id_pelicula") or
  die("Problemas en el select:".mysqli_error($conexion));

mysqli_close($conexion);
echo "<h2>Se efectuó el borrado del video.</h2>";
 //echo "<div><a href='exposicion.php'>volver a Consultar</a></div><br>";
?>
 
</form>
</body>
</html>