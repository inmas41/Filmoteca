<!DOCTYPE html>
<html lang="en">
<title>mi videoteca<?php echo ((isset($titulo_personalizado))?" - $titulo_personalizado":"")?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/estilo.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {font-family: "Lato", sans-serif}
.mySlides {display: none}
</style>
<body class="<?php echo ((isset($clase_body))?"$clase_body":"")?>">
<!-- Navbar on small screens (remove the onclick attribute if you want the navbar to always show on top of the content when clicking on the links) -->
<div class="w3-top">
  <div class="w3-bar w3-black w3-card">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="index.php" class="w3-bar-item w3-button w3-padding-large">HOME</a>
    <a href="exposicion.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Exposición</a>
    <a href="actualizar.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Actualizar</a>
    <a href="alta.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Catalogar</a>
    <a href="borrar.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Descatalogar</a>
    <div class="w3-dropdown-hover w3-hide-small">
      <button class="w3-padding-large w3-button" title="More">Mucho Mas <i class="fa fa-caret-down"></i></button>     
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="#" class="w3-bar-item w3-button">Generos</a>
        <a href="#" class="w3-bar-item w3-button">Edad</a>
        <a href="#" class="w3-bar-item w3-button">Subtitulos</a>
      </div>
    </div>
    <a href="javascript:void(0)" class="w3-padding-large w3-hover-red w3-hide-small w3-right"><i class="fa fa-search"></i></a>
  </div>
</div>

<!-- Navbar on small screens (remove the onclick attribute if you want the navbar to always show on top of the content when clicking on the links) -->
<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:50px">
    <a href="exposicion.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Exposicion</a>
    <a href="actualizar.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Actualizar</a>
  <a href="alta.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Catalogar</a>
  <a href="borrar.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Descatalogar</a>
</div>

<!-- Page content -->
<div class="w3-content" style="max-width:2000px;margin-top:46px">