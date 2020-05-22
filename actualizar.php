<?php
$titulo_personalizado = "Actualizar";
$clase_body = "body_actualizar";
include 'cabecera.php';

//Aqui vamos a ubicar la coneccion con nuestra base de datos 
include 'configuracion.php';
$conexion = new mysqli(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
// Check connection
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

$video = null; //esta variable sera la que utilizaremos para asegurarnos que el titulo no esta vacio
$mensaje_update = ""; //Este string sera el encargado de nuestro mensaje 

if (count($_POST) > 0) {//una vez se selccione el video le hacemos el select
    if (isset($_POST['video_seleccionado'])) { //pasamos a la misma pagina en vez de hacer otra
        $sql = "SELECT * FROM pelicula WHERE id_pelicula = " . $_POST['video_seleccionado'];
        $result = $conexion->query($sql); //aqui le mandamos la orden que seleccione los datos del libro seleccionado

        if ($result->num_rows > 0) {
            $video = $result->fetch_assoc(); //en vez de escribir $row le estoy poniendo $video
        }
    } else {//$titulo = $fechaEstreno = $director = $genero = $dni = $nacionalidad = $min = $imagen = $fechaPrestamo = "";
        $titulo = test_input($_POST['titulo']);
        $fechaEstreno = test_input($_POST['fechaEstreno']);
        $director = test_input($_POST['director']);
        $genero = ($_POST['genero']);
        $dni = test_input($_POST['dni']);
        $nacionalidad = test_input($_POST['nacionalidad']);
        $min = test_input($_POST['min']);
        $fechaPrestamo = test_input($_POST['fechaPrestamo']);
        $id_pelicula = $_POST['id_pelicula'];

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

        $sql_logo = "";
        if ($_FILES["imagen"]['error'] == UPLOAD_ERR_OK) {
            $logotipo = $_FILES["imagen"]["name"];
            $sql_logo = ", imagen   = '$logotipo'";

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


        if ($formularioValido) {
            //una vez inicializada las variables procedemos a la modificacion con el update
            $sql = "UPDATE pelicula SET 
                            titulo = '$titulo',
                            fechaEstreno = '$fechaEstreno',
                            director = '$director',
                            genero = '$genero',
                            dni = '$dni',
                            nacionalidad = '$nacionalidad',
                            min='$min',
                            fechaPrestamo= '$fechaPrestamo'
                            $sql_logo
                        WHERE id_pelicula = $id_pelicula";

            if ($conexion->query($sql) === TRUE) {
                $mensaje_update = "Registro modificado correctamente";

                if ($_FILES["imagen"]['error'] == UPLOAD_ERR_OK) {
                    $target_dir = "upload/"; //la foto que vayas subiendo ira guardandose en la carpeta uploads, sino abres esta carpeta no subira el archivo.
                    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);

                    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                        $mensaje_update .= "<br/>Error: Lo siento, se ha producido un error al subir la imagen";
                    }
                }
            } else {
                $mensaje_update = "Error: " . $sql . "<br>" . $conexion->error;
            }
        } else {
            $sql = "SELECT * FROM pelicula WHERE id_pelicula = " . $id_pelicula;
            $result = $conexion->query($sql); //aqui le mandamos la orden que seleccione los datos del libro seleccionado

            if ($result->num_rows > 0) {
                $video = $result->fetch_assoc(); //en vez de escribir $row le estoy poniendo $video
            }
        }
    }
}//si la coneccion es verdadera o falsa utilizamos la variable de string($mensaje_update)


$sql = "SELECT * FROM pelicula ORDER BY titulo";
$result = $conexion->query($sql);
?>
<div class="w3-row">
    <div class="w3-col s12 m8 l6" style="margin: 0 auto; float: none;">
        <div class="w3-container w3-gray w3-opacity-min w3-card-4  w3-text-white w3-margin">
            <form class="w3-text-white" action="" method="post">
                <h2>Seleccione el film a editar: </h2>
                <select name='video_seleccionado' class="w3-input w3-border w3-margin-bottom" required=""> <!--Aqui estamos utilizando la variable de libro seleccionado que utilizamos en el select-->
                    <option value="">-- seleccione un título --</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $selected = ""; //esta variable la utilizare para que el libro seleccionado  en el combo siga marcado una vez pulsemos en el input
                            if ($video != null && $video['id_pelicula'] == $row['id_pelicula']) {
                                $selected = "selected";
                            }

                            echo "<option value='{$row['id_pelicula']}' $selected>" . $row['titulo'] . "</option>";
                        }
                    }//cierro el combo y pulsamos en el input que lo tengo fuera de php para no liarme tanto
                    ?>
                </select>
                <input type="submit" class="w3-button w3-section w3-grey w3-ripple" value="Seleccionar"/><br>
                </div>
                </div>
                </div>
            </form>
            <?php
            if ($mensaje_update != "") {//Aqui le decimos que si no esta vacio que lo muestre
                echo "<p>$mensaje_update</p>";
            }
//esto es para que se vea el formulario completo reflejado una vez este seleccionado el video, mientras no sera visible
            if ($video != null) {//si video no esta vacio mostrara el formulario con los datos seleccionados y el id lo tengo oculto
                $logo_libro = 'upload/default.jpg';
                if (!empty($video['imagen'])) {
                    $imagen = 'upload/' . $video['imagen'];
                    if (file_exists($imagen)) {
                        $logo_libro = $imagen;
                    }
                }
                ?>
                <header class="w3-container w3-gray w3-text-white w3-center">
                    <h2> Formulario de Registro </h2>
                </header>
                <div class="w3-row">
                    <div class="w3-col s12 m8 l6" style="margin: 0 auto; float: none;">
                        <div class="w3-container w3-gray w3-opacity-min w3-card-4  w3-text-white w3-margin">
                            <form  method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"><!--enctype="multipart/form-data" autocomplete="on"-->

                                <legend>Datos del nuevo film</legend>
                                <p><span class="w3-text-red">Required field*</span></p>
                                <input type="hidden" name="id_pelicula" value="<?php echo $video['id_pelicula'] ?>" />

                                <label for="titulo">Titulo *</label> 
                                <input class="w3-input w3-border w3-margin-bottom" type="text" id="titulo" name="titulo"  value="<?php echo $video['titulo'] ?>" >
                                <span class="w3-text-red"> <?php echo $tituloErr; ?></span><br>

                                <label for="fechaEstreno">Fecha de Estreno *</label>
                                <input class="w3-input w3-border w3-margin-bottom" type="date" id="fechaEstreno" name="fechaEstreno" value="<?php echo $video['fechaEstreno'] ?>">
                                <span class="w3-text-red"> <?php echo $fechaEstrenoErr; ?></span><br>

                                <label for="director">Director </label>
                                <input class="w3-input w3-border w3-margin-bottom" type="text" id="director" name="director" value="<?php echo $video['director'] ?>">
                                <span class="w3-text-red"> <?php echo $directorErr; ?></span><br>

                                <label for="genero">Genero </label>
                                <select name="genero" type= "text" id="director" class="w3-input w3-border w3-margin-bottom" value="<?php echo $video['genero'] ?>">
                                    <option value="">-- Seleccione un Genero --</option>
                                    <option value="Suspense" <?php echo ($video['genero'] == "Suspense")?"selected":""?>>Suspense</option>
                                    <option value="Humor" <?php echo ($video['genero'] == "Humor")?"selected":""?>>Humor</option>
                                    <option value="Amor" <?php echo ($video['genero'] == "Amor")?"selected":""?>>Amor</option>
                                    <option value="Accion" <?php echo ($video['genero'] == "Accion")?"selected":""?>>Accion</option>
                                    <option value="Terror" <?php echo ($video['genero'] == "Terror")?"selected":""?>>Terror</option>
                                </select><!--tinyint(1) es otra manera de contabilizar los numeros (01)como un Bit;-->
                                <!--<span class="w3-text-red"> <?php echo $generoErr; ?></span><br>-->

                                <label for="dni">DNI Socio: *</label>
                                <input class="w3-input w3-border w3-margin-bottom" type="text" name="dni" value="<?php echo $video['dni'] ?>">
                                <span class="w3-text-red"> <?php echo $dniErr; ?></span><br>

                                <label for="nacionalidad"> Nacionalidad: *</label>

                                <select name="nacionalidad" class="w3-input w3-border w3-margin-bottom" value="<?php echo $video['nacionalidad'] ?>">
                                    <?php
                                    $sql = "SELECT id, nombre FROM nacionalidad ORDER BY nombre";
                                    $rs = mysqli_query($conexion, $sql); //RecordSet(conjunto de registros)

                                    while (($row = mysqli_fetch_assoc($rs)) !== null)://mysqli_fetch_assoc() que retorna una fila de la consulta hecha en forma de clave => valor
                                        //mysqli_fetch_assoc => Retorna un arreglo multidimensional de los valores consultados
                                        $selected = "";
                                        if ($row['id'] == $video['nacionalidad']){
                                            $selected = "selected";
                                        }
                                        ?>
                                        <option value="<?php echo $row['id'] ?>" <?php echo $selected?>><?php echo $row['nombre'] ?></option>
                                        <?php
                                    endwhile;
                                    ?>
                                </select><br>

                                <span class="w3-text-red"> <?php echo $nacionalidadErr; ?></span>
                                <br>

                                <label for="min">Duracion: *</label>
                                <input class="w3-input w3-border w3-margin-bottom" type="number" name="min"  placeholder="123-" value="<?php echo $video['min'] ?>">
                                <span class="w3-text-red"><?php echo $minErr; ?></span><br>


                                <label for="imagen">Portada: *</label><br> 
                                <img src="<?php echo $imagen ?>" style="width:80px ; height:80px">
                                <input class="w3-input w3-border w3-margin-bottom" name="imagen"  type="file" ><br>


                                <label for="date"> Fecha de Prestamo: *</label>
                                <?php
                                    //Guardamos la fecha en un tipo datetime para luego poder utilizar la parte que nos interese.
                                    $datetime = DateTime::createFromFormat('Y-m-d h:i:s', $video['fechaPrestamo']);
                                ?>
                                <input class="w3-input w3-border w3-margin-bottom" type="date" name="fechaPrestamo" id="fechaPrestamo" value="<?php echo $datetime->format('Y-m-d') ?>">
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
            