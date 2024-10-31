<?php
//include_once '../connection/data.php';
$conexion = new Contacts();
$alerta = $conexion->getAlert();
$class = 'alertHiden';
if($alerta[0]['active'] == 1)
  $class = ''
?>
<section id="alertRibon" class="alertRibon <?php echo $class; ?>">
  ⚠️<?php echo $alerta[0]['coment']; ?>⚠️
</section>