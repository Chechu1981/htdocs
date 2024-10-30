<?php
include_once '../connection/data.php';
$conexion = new Contacts();
$checked = '';
$alerta = $conexion->getAlert();
if($alerta[0]['active'] == 1)
  $checked = 'checked';
?>
<div class="switch">
  <input type="checkbox" <?php echo $checked; ?>>
  <div></div>
</div>
<textarea class="edit-notes" style="height:200px" name="" id="txtNotes" cols="30" rows="10">
<?php echo str_replace("<br />","\r\n",$alerta[0]['coment']); ?>
</textarea>
<input type="button" id="saveNotes" value="Guardar">