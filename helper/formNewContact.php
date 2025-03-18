<?php
$id = @$_GET["id"];
$centro = @$_GET["placa"];
$entidad = ''; 
$equipo = ''; 
$nombre = ''; 
$puesto = ''; 
$ext =''; 
$nlargo = ''; 
$movil = ''; 
$ncorto = ''; 
$correo = '';
$accion = 'Crear contacto';
$titulo = 'new';
if($id != '') {
  include_once '../connection/data.php';
  $conexion = new Contacts();
  $contact = $conexion->getAllCenter($id);
  $centro = $contact[0][1]; 
  $entidad = $contact[0][2]; 
  $equipo = $contact[0][3]; 
  $nombre = $contact[0][4]; 
  $puesto = $contact[0][5]; 
  $ext = $contact[0][6];
  $nlargo = $contact[0][7]; 
  $movil = $contact[0][8]; 
  $ncorto = $contact[0][9]; 
  $correo = $contact[0][10];
  $accion = 'Guardar contacto';
  $titulo = 'update';
}
$PLACAS = [
  "PPCR SERVICIOS CENTRALES",
  "PPCR MADRID",
  "PPCR SEVILLA",
  "PPCR SANTIAGO",
  "PPCR GRANADA",
  "PPCR ZARAGOZA",
  "PPCR BALEARES",
  "PPCR VALENCIA",
  "PPCR BARCELONA"
];
$ENTIDAD = [
  "PPCR",
  "GECOINSA",
  "CEVA",
  "TRANSPORTE",
  "NORTEMPO",
  "FOMINTER",
  "PCAE",
  "INMOSANMAR",
  "MNP&MAKA S.L",
  "SELIGISTICA"
];
$EQUIPO = [
  "COMERCIO",
  "EXPLOTACION",
  "GESTION",
  "POA/ADMON",
  "DISTRIBUCION",
  "DIRECCION",
  "APROVISIONAMIENTO",
  "CALL CENTER",
  "LOGISITICA"
];
?>
<link rel="stylesheet" href="../css/style28.css?100" type="text/css" />
<link rel="stylesheet" href="../css/chechu.css?100" type="text/css" />
<form class='formNewContact' title='<?= $titulo ?>'>
    <input type="hidden" value="${centro}">
    <label for="placa">Placa</label>
    <select type='text' placeholder='placa' id='placa'>
      <option value="" disabled hidden selected></option>
      <?php foreach ($PLACAS as $placa) {
        $selected = "";
        if ($placa == $centro) 
          $selected = "selected"; ?>
        <option value="<?= $placa ?>" <?= $selected ?> ><?= $placa ?></option>
      <?php } ?>  
    </select>
    <label for="entidad">Entidad</label>
    <select type='text' placeholder='entidad' id='entidad'>
      <option value="" disabled hidden selected></option>
      <?php foreach ($ENTIDAD as $placa) { 
        $selected = "";
        if ($placa == $entidad) 
          $selected = "selected"; ?>
        <option value="<?= $placa ?>" <?= $selected ?> ><?= $placa ?></option>
      <?php } ?>  
    </select>
    <label for="equipo">Equipo</label>
    <select type='text' placeholder='equipo' id='equipo'>
      <option value="" disabled hidden selected></option>
      <?php foreach ($EQUIPO as $placa) { 
        $selected = "";
        if ($placa == $equipo) 
          $selected = "selected"; ?>
        <option value="<?= $placa ?>" <?= $selected ?> ><?= $placa ?></option>
      <?php } ?>  
    </select>
    <label for="nombre"></label><input type='text' placeholder='nombre' id='nombre' value="<?= $nombre ?>">
    <label for="puesto"></label><input type='text' placeholder='puesto' id='puesto' value="<?= $puesto ?>">
    <label for="ext"></label><input type='text' placeholder='ext' id='ext' value="<?= $ext ?>">
    <label for="nlargo"></label><input type='text' placeholder='nº largo' id='nlargo' value="<?= $nlargo ?>">
    <label for="movil"></label><input type='text' placeholder='móvil' id='movil' value="<?= $movil ?>">
    <label for="ncorto"></label><input type='text' placeholder='nº corto' id='ncorto' value="<?= $ncorto ?>">
    <label for="correo"></label><input type='text' placeholder='correo' id='correo' value="<?= $correo ?>">
    <input type='hidden' placeholder='id' id='id' value="<?= $id ?>">
    <label for=""></label>
    <input type='submit' class='note-btn' style="width:150px;justify-content:center" value='<?= $accion ?>'>
</form>
<script src="../js/formContacts.js"></script>