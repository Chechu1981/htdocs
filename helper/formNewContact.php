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
$ENTIDAD = [
  "PPCR",
  "GECOINSA",
  "CEVA",
  "TRASNPORTE",
  "NORTEMPO",
  "FOMINTER",
  "PCAE",
  "INMOSANMAR",
  "MNP&MAKA S.L"
];
$EQUIPO = [
  "COMERCIO",
  "EXPLOTACIÓN",
  "GESTION",
  "POA/ADMON",
  "DISTRIBUCIÓN",
  "DIRECCIÓN",
  "APROVISIONAMIENTO",
  "CALL CENTER",
  "LIGÍSITICA"
];
?>
<link rel="stylesheet" href="../css/style28.css" type="text/css" />
<link rel="stylesheet" href="../css/chechu.css" type="text/css" />
<form class='formNewContact' title='new'>
    <input type="hidden" value="${centro}">
    <label>Placa</label>
    <select type='text' placeholder='placa' id='placa'>
      <option value="" disabled hidden selected></option>
      <?php foreach ($PLACAS as $placa) { ?>
        <option value="<?= $placa ?>"><?= $placa ?></option>
      <?php } ?>  
    </select>
    <label>Entidad</label>
    <select type='text' placeholder='entidad' id='entidad'>
      <option value="" disabled hidden selected></option>
      <?php foreach ($ENTIDAD as $placa) { ?>
        <option value="<?= $placa ?>"><?= $placa ?></option>
      <?php } ?>  
    </select>
    <label>Equipo</label>
    <select type='text' placeholder='equipo' id='equipo'>
      <option value="" disabled hidden selected></option>
      <?php foreach ($EQUIPO as $placa) { ?>
        <option value="<?= $placa ?>"><?= $placa ?></option>
      <?php } ?>  
    </select>
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