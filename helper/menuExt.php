<?php
$contacts = new Contacts();
$usuario = $_COOKIE['user'];
$hash = $_COOKIE['id'];
$puesto = $_COOKIE['puesto'];


$titulo = "Cesiones de " . $usuario;
?>
<section class="subButtons">
  <button id="new">Nueva compra</button>
  <button id="all">Todas</button>
</section>