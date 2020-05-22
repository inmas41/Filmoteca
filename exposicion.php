<!--<html>
    <head>
         <meta charset="UTF-8">
        <link rel="stylesheet" href="css/w3.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <title>Consultas</title>
        <style>
            body {
                background-image:url(upload/warner.jpg);
                background-size: 100vw 100vh;
                background-attachment:fixed;
                margin: 0;
                font-family: monospace;
                
            }
        </style>
    </head>
    <body> -->





<?php
$titulo_personalizado = "Consultas";
$clase_body = "body_consultar";

include 'cabecera.php';
include 'configuracion.php';
?>

<div class="alert alert-info ">
    <h2 class="w3-text-white">Filtro de Búsqueda PHP</h2>
</div>
<form action="exposicion.php" method="post">
    Palabras Relacionadas:
    <input type="text" name="titulo" value="">
    <input type="submit" value="Buscar">
</form>  
<form   action="" method="GET">

    <?php
    $conexion = new mysqli(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }
    $titulo = isset($_REQUEST['titulo']) ? $_REQUEST['titulo'] : '';
    $sql = "SELECT * FROM pelicula where titulo like '%$titulo%'";
    $result = $conexion->query($sql);

    $titulo = 'titulo';
    $target_file = 'imagen';
    $imagen = "<img src='$target_file'>";
    if ($result->num_rows > 0) {
        // output data of each row

        echo '<table class= "w3-table w3-text-white">';
        $pintar_cabecera = true;
        while ($row = $result->fetch_assoc()) {//titulo, fechaEstreno, director, genero, dni, nacionalidad, telefono, imagen ,fechaPrestamo)                                                         
            if ($pintar_cabecera) {
                ?>
                <tr>
                    <th>ID</th>'
                    <th>Titulos</th>
                    <th>Fecha De Estreno</th>
                    <th>Director</th>
                    <th>Genero</th>
                    <th>DNI</th>
                    <th>Nacionalidad</th>
                    <th>Duracion</th>
                    <th>imagen</th>
                    <th>Fecha De Prestamo</th>
                    <th>Borrado</th>
                </tr>
                <?php
                $pintar_cabecera = false;      //soource format
            }
            ?>

            <tr>
                <td><?php echo $row["id_pelicula"] ?></td>
                <td><?php echo $row["titulo"] ?></td>
                <td><?php echo $row["fechaEstreno"] ?></td>
                <td><?php echo $row["director"] ?></td>
                <td><?php echo $row["genero"] ?></td>
                <td><?php echo $row["dni"] ?></td>
                <td><?php echo $row["nacionalidad"] ?></td>
                <td><?php echo $row["min"] ?></td>
                <td><img  style="width:80px ; height:80px" alt=" No hay imagen " src="upload/<?php echo $row["imagen"] ?>"></td>
                <td><?php echo $row["fechaPrestamo"] ?></td>
                <td>
                    <div class="w3-cont"><a href="#miModal_<?php echo $row["id_pelicula"] ?> " style='text-decoration:none'>Borrar</a></div>
                    <div id="miModal_<?php echo $row["id_pelicula"] ?>" class="w3-modal">
                        <div class="w3-modal-content">
                            <a style="margin-left:97%; border:0px;background-color: aqua;color:black" href="#">X</a>
                            <h2 class="w3-button w3-display-topright">Confirmacion del Borrado</h2>
                            <p>Esta usted confirmando que quiere borrar un libro</p>
                            <a href="#borradoti.php?titulo=<?php echo $row["id_pelicula"] ?>">Borrar!!</a>
                        </div>  
                    </div>
                </td>
            </tr>
            <?php
        }
        echo '</table>';
    } else {
        echo "0 results";
    }

    $conexion->close();

    // echo" <div><a href='borrado.php'> Borrar libro </a></div><br> ";
    ?>

</form></div><br>
<!--<button class="w3-button w3-section w3-grey w3-ripple"><a  style="text-decoration:none" href="index.html">volver a Inicio</a></button>-->
</body>
</html>
<?php
include 'pie.php';




