<?php
$clase_body = "body_alta";
$titulo_personalizado = "alta";
include 'cabecera.php';


include 'configuracion.php';

$conexion = new mysqli(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);

if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");

function test_input($data) {
    $clear_data = trim($data);
    $clear_data = stripslashes($clear_data);
    $clear_data = htmlspecialchars($clear_data);
    return $clear_data;
}

//id_pelicula 	titulo 	fechaEstreno 	director 	genero 	url 	nacionalidad 	telefono 	imagen 	fechaPrestamo
$tituloErr = $fechaEstrenoErr = $directorErr = $generoErr = $dniErr = $nacionalidadErr = $minErr = $imagenErr = $fechaPrestamoErr = "";
$titulo = $fechaEstreno = $director = $genero = $dni = $nacionalidad = $min = $imagen = $fechaPrestamo = "";
$formularioValido = true;
if (count($_POST) > 0) {

    $titulo = test_input($_POST['titulo']);
    $fechaEstreno = test_input($_POST['fechaEstreno']);
    $director = test_input($_POST['director']);
    $genero = ($_POST['genero']);
    $dni = test_input($_POST['dni']);
    $nacionalidad = test_input($_POST['nacionalidad']);
    $min = test_input($_POST['min']);
    $imagen = $_FILES["imagen"]["name"];
    $fechaPrestamo = test_input($_POST['fechaPrestamo']);

    //bloque validación de titulo
    if (empty($titulo)) {
        $tituloErr = "Titulo es requerido";
        $formularioValido = false;
    } else {
        if (strlen($titulo) > 45) {
            $tituloErr = "El campo titulo no puede tener mas de 45 carácteres";
            $formularioValido = false;
        }
    }
    //bloque validacion de fechaEstreno
    if (empty($fechaEstreno)) {
        $fechaEstrenoErr = "La fecha de estreno  es requerido";
        $formularioValido = false;
    }
    //bloque validacion de director
    if (empty($director)) {
        $directorErr = "El director es requerido";
        $formularioValido = false;
    } else {
        if (strlen($director) > 45) {
            $directorErr = "El campo del no puede tener mas de 45 carácteres";
            $formularioValido = false;
        }
    }
    //bloque validacion de genero
    if (empty($genero)) {
        $generoErr = "El genero es requerido";
        $formularioValido = false;
    }

    $mimes_validos = array(
        'image/gif',
        'image/png',
        'image/jpeg',
        'image/bmp',
        'image/webp'
    );

    if (!in_array(mime_content_type($_FILES["imagen"]["tmp_name"]), $mimes_validos)) {
        $imagenErr = "Fichero no válido!!";
        $formularioValido = false;
    }
}
if (count($_POST) > 0 && $formularioValido) {
    $sql = "INSERT INTO pelicula ( titulo, fechaEstreno, director, genero, dni, nacionalidad, min, imagen ,fechaPrestamo)
                     VALUES ('$titulo','$fechaEstreno','$director','$genero','$dni','$nacionalidad','$min','$imagen','$fechaPrestamo')";

    if ($conexion->query($sql) === TRUE) {
        echo "<h1>Registro creado correctamente</h1>";
        //header("Location: consultas.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }

    $target_dir = "upload/"; //la foto que vayas subiendo ira guardandose en la carpeta uploads, sino abres esta carpeta no subira el archivo.
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);

    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        echo " El archivo ha sido subido correctamente<br>";
        echo "<img src='$target_file'>";
    } else {
        echo "Lo siento, se ha producido un error al subir la imagen";
    }
} else {
    ?>
   <!-- <html>
        <head>
            <meta charset="UTF-8">
            <title>Capeando</title>
            <style>
                body {
                    background-image:url(upload/oregon.jpg);
                    background-size: 100vw 100vh;
                    background-attachment:fixed;
                    margin: 0;
                    font-family: monospace;

                }


            </style>
        </head>-->
        <header class="w3-container w3-gray w3-text-white w3-center">
            <h2> Formulario de Registro </h2>
        </header>
        <div class="w3-row">
            <div class="w3-col s12 m8 l6" style="margin: 0 auto; float: none;">
                <div class="w3-container w3-gray w3-opacity-min w3-card-4  w3-text-white w3-margin">
                    <form  method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"><!--enctype="multipart/form-data" autocomplete="on"-->

                        <legend>Datos del nuevo film</legend>
                        <p><span class="w3-text-red">Required field*</span></p>

                        <label for="titulo">Titulo *</label> 
                        <input class="w3-input w3-border w3-margin-bottom" type="text" id="titulo" name="titulo"  value="<?php echo $titulo ?>" >
                        <span class="w3-text-red"> <?php echo $tituloErr; ?></span><br>

                        <label for="fechaEstreno">Fecha de Estreno *</label>
                        <input class="w3-input w3-border w3-margin-bottom" type="date" id="fechaEstreno" name="fechaEstreno" value="<?php echo $fechaEstreno ?>">
                        <span class="w3-text-red"> <?php echo $fechaEstrenoErr; ?></span><br>

                        <label for="director">Director </label>
                        <input class="w3-input w3-border w3-margin-bottom" type="text" id="director" name="director" value="<?php echo $director ?>">
                        <span class="w3-text-red"> <?php echo $directorErr; ?></span><br>

                        <label for="genero">Genero </label>
                        <select name="genero" value="<?php echo $director ?>" class="w3-input w3-border w3-margin-bottom">
                            <option value="">-- Seleccione un Genero --</option>
                            <option value="Suspense">Suspense</option>
                            <option value="Humor">Humor</option>
                            <option value="Amor">Amor</option>
                            <option value="Accion">Accion</option>
                            <option value="Tw3-text-red">Tw3-text-red</option>
                        </select><!--tinyint(1) es otra manera de contabilizar los numeros (01)como un Bit;-->
                        <span class="w3-text-red"> <?php echo $generoErr; ?></span><br>

                        <label for="dni">DNI Socio: *</label>
                        <input class="w3-input w3-border w3-margin-bottom" type="text" name="dni" value="<?php echo $dni ?>">
                        <span class="w3-text-red"> <?php echo $dniErr; ?></span><br>

                        <label for="nacionalidad"> Nacionalidad: *</label>

                        <select name="nacionalidad" class="w3-input w3-border w3-margin-bottom">
    <?php
    $sql = "SELECT id, nombre FROM nacionalidad ORDER BY nombre";
    $rs = mysqli_query($conexion, $sql); //RecordSet(conjunto de registros)

    while (($row = mysqli_fetch_assoc($rs)) !== null)://mysqli_fetch_assoc() que retorna una fila de la consulta hecha en forma de clave => valor
        //mysqli_fetch_assoc => Retorna un arreglo multidimensional de los valores consultados
        ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre'] ?></option>
                                <?php
                            endwhile;
                            ?>
                        </select><br>

                        <span class="w3-text-red"> <?php echo $nacionalidadErr; ?></span>
                        <br>

                        <label for="min">Duracion: *</label>
                        <input class="w3-input w3-border w3-margin-bottom" type="number" name="min"  placeholder="123-" value="<?php echo $min ?>">
                        <span class="w3-text-red"><?php echo $minErr; ?></span><br>


                        <label for="imagen">Portada: *</label> 
                        <input class="w3-input w3-border w3-margin-bottom" id="imagen" name="imagen" size="40" type="file" required="" value="<?php echo $imagen ?>">
                        <span class="w3-text-red"><?php echo $imagenErr; ?></span><br>

                        <label for="date"> Fecha de Prestamo: *</label>
                        <input class="w3-input w3-border w3-margin-bottom" type="date" name="fechaPrestamo" placeholder="Ej:" value="<?php echo $fechaPrestamo ?>">
                        <span class="w3-text-red"><?php echo $fechaPrestamoErr; ?></span><br>

                                        <!--<input type="submit" value="Enviar">-->
                        <p class="w3-center">
                            <button class="w3-button w3-section w3-grey w3-ripple"> Enviar</button>


                    </form>
                </div>
            </div>
        </div>
    <?php
}

include 'pie.php';
