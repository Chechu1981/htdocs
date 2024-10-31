<?php
include_once '../connection/data.php';
$conexion = new Contacts();
$checked = '';
$classSwh = 'switchOff';
$alerta = $conexion->getAlert();
if($alerta[0]['active'] == 1){
  $checked = 'checked';
  $classSwh = 'switchOn';
}
?>
<div class="switch">
  <input type="checkbox" id="chkBtn" <?php echo $checked; ?>>
  <div id="swhBtn" class="<?php echo $classSwh; ?>"></div>
</div>
<textarea class="edit-notes" style="height:200px" name="" id="txtNotes" cols="30" rows="10">
<?php echo str_replace("<br />","\r\n",$alerta[0]['coment']); ?>
</textarea>

<input type="button" id="saveAlert" value="Aceptar">