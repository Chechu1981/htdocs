<?php
  include_once '../connection/data.php';
  $conexion = new Contacts();

  $amperios = @$_POST['amperios'];
  $stopStart = @$_POST['stopStart'];
  $normal = @$_POST['normal'];
  if($amperios == '')
    $amperios = 76;
  if($stopStart == '')
    $stopStart = '';
  if($normal == '')
    $normal = '';
  $aceite = $conexion->getBattery($amperios,$stopStart,$normal);

  function formatRef($referencia){
    $conexion = new Contacts();
    return $conexion->formatRef(trim($referencia," "));
  }

  function getBorne($numBorne){
    if($numBorne == 3)
      return "JAPÓN";
    else  
      return "EUROPA";
  }

  function getPositivo($numPositivo){
    if($numPositivo == 0)
      return "+ DCHA";
    else
      return "+ IZDA";
  }

?>
<table class="table_oil">
  <tr>
    <th>Capacidad</th>
    <th>Amperios</th>
    <th>S&S</th>
    <th>Referencia</th>
    <th>Descripción</th>
    <th>Largo</th>
    <th>Alto</th>
    <th>Ancho</th>
    <th>Polaridad</th>
    <th>Borne</th>
  </tr>
  <?php 
  foreach ($aceite as $items){ 
    $referencia = str_replace('.','',$items[3]);
  ?>
    <tr>
      <td><?php echo $items[1].'A';?></td>
      <td><?php echo $items[0].'Ah';?></td>
      <td style="width:120px;text-align:center"><?php echo $items[2];?></td>
      <td class="copy" style="font-weight: bolder;"><?php echo formatRef($referencia); ?></td>
      <td><?php echo $items[4];?></td>
      <td><?php echo $items[5];?></td>
      <td><?php echo $items[7];?></td>
      <td><?php echo $items[6];?></td>
      <td><?php echo getPositivo($items[8]);?></td>
      <td><?php echo getBorne($items[9]);?></td>
    </tr>
  <?php } ?>
</table>