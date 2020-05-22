<?php
$titulo_personalizado = "Borrado";
$clase_body = "body_borrar";
include 'cabecera.php';


?>


    <div class="w3-row">
        <div class="w3-col s12 m8 l6" style="margin: 0 auto; float: none;">
            <div class="w3-container w3-gray  w3-card-4  w3-text-white w3-margin">
                <form action=""class="w3-text-white" method="post">
                    <h3>Palabras Relacionadas</h3>
                    <input type="text" class='w3-input w3-border w3-margin-bottom' name="titulo" value=""/>
                    <input type="submit" class='w3-input w3-border w3-margin-bottom' value="Buscar"/>
                </form>  
            </div>
        </div>
    </div>
    <div class="w3-row">
        <div class="w3-col s12 m8 l6" style="margin: 0 auto; float: none;">
            <div class="w3-container w3-gray  w3-card-4  w3-text-white w3-margin">

                <form action= "borrado.php" method="GET">
                    <h3>Señale la pelicula</h3>




                    <?php
                   
                    include 'configuracion.php';
                    $conexion = new mysqli(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                    $conexion->set_charset("utf8");

// Check connection
                    if ($conexion->connect_error) {
                        die("Connection failed: " . $conexion->connect_error);
                    }
//Si se cumple "condicion" devuelvo valor1, en caso contrario valor2.OPERADOR TERNARIO
//[condicion]?[valor1]:[valor2]
                    $titulo = isset($_REQUEST['titulo']) ? $_REQUEST['titulo'] : '';
                    $sql = "SELECT * FROM pelicula
                              WHERE titulo LIKE '%$titulo%'"; //like no discrimina en minuscula o mayuscula, ni siquiera acentos
                    /* if (!empty($buscar)){
                      $sql .= " WHERE titulo LIKE '%$buscar%'";
                      } */
                    $result = $conexion->query($sql);
//echo $_POST['titulo'];
                    ?>

                    <?php
                    echo "<select name='titulo' class='w3-input w3-border w3-margin-bottom'>"; //titulo es la variable escogida para hacer la operacion del borrado
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {


                            echo "<option value='{$row['id_pelicula']}'>" . $row['titulo'] . "</option><br>";
                        }
                    }
                    echo "</select><br>";
// echo "0 results";
                    $conexion->close();
                    ?>            


                    <!-- Modal -->
                    <div class="w3-container">
                        <button type="button" onclick="document.getElementById('id01').style.display = 'block'" class="w3-button w3-black">Open Modal</button>

                        <div id="id01" class="w3-modal">
                            <div class="w3-modal-content">

                                <span onclick="document.getElementById('id01').style.display = 'none'" 
                                      class="w3-button  w3-text-black w3-display-topright">&times;</span>

                                <div class="w3-container w3-text-black" >
                                    <h2>Estas a punto de borrar este film</h2>
                                    <input type="submit" class='w3-button w3-section w3-grey w3-ripple' value="Borrar" />
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>





<?php include 'pie.php' ?>