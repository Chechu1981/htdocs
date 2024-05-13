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
    if($numBorne == 1)
      return "../img/japan.svg";
    else  
      return "../img/europe.svg";
  }

  function getPositivo($numPositivo){
    if($numPositivo == 'd')
      return "+ DCHA";
    else
      return "+ IZDA";
  }

?>
<table class="table_oil">
  <tr style="position:sticky;top: 162px;">
    <th>Capacidad</th>
    <th>Amperios</th>
    <th>S&S</th>
    <th>Referencia</th>
    <th>Descripción</th>
    <th>Largo</th>
    <th>Ancho</th>
    <th>Alto</th>
    <th>Polaridad</th>
    <th>Borne</th>
    <th>Talón</th>
    <th>Bandeja</th>
  </tr>
  <?php 
  foreach ($aceite as $items){ 
    $referencia = str_replace('.','',$items[3]);
  ?>
    <tr>
      <td><?= $items[1].'Ah';?></td>
      <td><?= $items[2].'A';?></td>
      <td style="width:120px;text-align:center"><?= $items[4];?></td>
      <td class="copy" style="font-weight: bolder;"><?= formatRef($referencia); ?></td>
      <td><?= strtoupper($items[5]);?></td>
      <td><?= $items[6];?></td>
      <td><?= $items[7];?></td>
      <td><?= $items[8];?></td>
      <td><?= getPositivo($items[9]);?></td>
      <td><img src="<?= getBorne($items[10]);?>" alt="borne"></td>
      <td><?= $items[11];?></td>
      <td><?= $items[12];?></td>
    </tr>
  <?php } ?>
</table>