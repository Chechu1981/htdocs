<?php
$id = @$_GET["id"];
if($id != '') {
  include_once '../connection/data.php';
  $conexion = new Contacts();
  $link = $conexion->getPassId($id);
}
$PLACAS = [
  "MADRID",
  "SEVILLA",
  "GALICIA",
  "GRANADA",
  "ZARAGOZA",
  "PALMA",
  "VALENCIA",
  "BARCELONA"
];
?>
<link rel="stylesheet" href="../css/style28.css" type="text/css" />
<link rel="stylesheet" href="../css/chechu.css" type="text/css" />
<form class='form-new' title='new'>
    <input type="hidden" value="${centro}">
    <label></label>
    <select type='text' placeholder='placa' id='placa'>
      <option value="" disabled hidden selected></option>
      <?php foreach ($PLACAS as $placa) { ?>
        <option value="<?= $placa ?>"><?= $placa ?></option>
      <?php } ?>  
    </select>
    <label></label><input type='text' placeholder='entidad' id='entidad'>
    <label></label><input type='text' placeholder='equipo' id='equipo'>
    <label></label><input type='text' placeholder='nombre' id='nombre'>
    <label></label><input type='text' placeholder='puesto' id='puesto'>
    <label></label><input type='text' placeholder='ext' id='ext'>
    <label></label><input type='text' placeholder='nº largo' id='nlargo'>
    <label></label><input type='text' placeholder='móvil' id='movil'>
    <label></label><input type='text' placeholder='nº corto' id='ncorto'>
    <label></label><input type='text' placeholder='correo' id='correo'>
    <input type='hidden' placeholder='id' id='id'>
    <input type='submit' class='note-btn' value='añadir'>
</form>
<script src="../js/form2.js?108"></script>