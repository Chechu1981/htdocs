<?php
$data = file_get_contents("../json/correos.json");
$products = json_decode($data, true);
?>
<h2><?php echo $_POST['title']; ?></h2>
<div>
  <legend>Destinatario</legend>
  <textarea name="destinatario" id="bcc" cols="30" rows="10" style="width: 452px; height: 74px;"><?php echo str_replace(';',"\r\n",$products[$_POST['title']]); ?></textarea>
  <legend>Con copia</legend>
  <textarea name="con copia" id="cc" cols="30" rows="10" style="width: 452px; height: 74px;"><?php echo str_replace(';',"\r\n",$products[$_POST['title'] . 'C']); ?></textarea>
  <legend>Mister-auto</legend>
  <textarea name="frágil" id="fcc" cols="30" rows="10" style="width: 452px; height: 74px;"><?php echo str_replace(';',"\r\n",$products[$_POST['title'] . 'F']); ?></textarea>
  <button id="save">Guardar</button>
</div>