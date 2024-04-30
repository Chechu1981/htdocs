<?php
$id = @$_GET["id"];
$links = [];
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
<form class='formNotebook' title='new'>
  <label></label><select type="text" placeholder="web" id="grupo">
    <option value="" selected disabled hidden></option>
    <option value="transporte">TRANSPORTE</option>
    <option value="neumaticos">NEUMÁTICOS</option>
    <option value="catalogo">CATÁLOGO</option>
    <option value="ppcr">PPCR</option>
    <option value="stellantis">STELLANTIS</option>
  </select>
  <label></label><input type='text' placeholder='Web' id='web' value="<?= @$link[0][9] ?>">
  <label></label><input type='text' placeholder='Nombre' id='marca' value="<?= @$link[0][1] ?>">
  <label></label>
    <select type='text' id='placa'>
      <option value="" selected>PLACA</option>
      <?php foreach ($PLACAS as $placa) { ?>
        <?php
          $selected = '';
          if($placa == $link[0][2]) { 
            $selected = 'selected';
          }
          ?>
        <option value="<?= $placa ?>" <?= $selected ?> ><?= $placa ?></option>
      <?php } ?>
    </select>
  <label></label><input type='text' placeholder='Cuenta' id='cuenta' value="<?= @$link[0][3] ?>">
  <label></label><input type='text' placeholder='Usuario' id='usuario' value="<?= @$link[0][4] ?>">
  <label></label><input type='text' placeholder='Contrsaeña' id='paswd' value="<?= @$link[0][5] ?>">
  <label></label><input type='text' placeholder='Teléfono' id='phone' value="<?= @$link[0][8] ?>">
  <input type='submit' value='añadir'>
</form>
<script src="../js/form2.js?108"></script>