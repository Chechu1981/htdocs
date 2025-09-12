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
  <button id="configExtMail" style="margin-left: 70%;" onclick="window.open('../../update/configExtMail.php', '_self')" title="Configurar correos externos">
    <i class="fa-solid fa-gear"></i>
  </button>
</section>