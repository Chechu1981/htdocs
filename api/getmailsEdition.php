<?php
$data = file_get_contents("../json/correos.json");
$products = json_decode($data, true);
?>
<h2><?php echo $_POST['title']; ?></h2>
<div>
  <legend><b>Destinatario como placa destino</b></legend>
  <textarea name="destinatario" id="bcc" cols="30" rows="10" style="width: 452px; height: 74px;"><?php echo str_replace(';',"\r\n",$products[$_POST['title']]); ?></textarea>
  <legend><b>Con copia</b></legend>
  <textarea name="con copia" id="cc" cols="30" rows="10" style="width: 452px; height: 74px;"><?php echo str_replace(';',"\r\n",$products[$_POST['title'] . 'C']); ?></textarea>
  <legend><b>Destinatarios como placa de origen</b></legend>
  <textarea name="origen" id="origen" cols="30" rows="10" style="width: 452px; height: 74px;"><?php echo str_replace(';',"\r\n",$products[$_POST['title'] . 'ORIGEN']); ?></textarea>
  <legend>
    <b>Mister-auto (Destino) / Frágil (Origen)</b><br>
    Estos correos se incluirán como origen cuando la cesión sea frágil o como destino si se trata de una cesión Misetr-Auto.
  </legend>
  <textarea name="frágil" id="fcc" cols="30" rows="10" style="width: 452px; height: 74px;"><?php echo str_replace(';',"\r\n",$products[$_POST['title'] . 'F']); ?></textarea>
  <button id="save">Guardar</button>
</div>