<?php
$id = @$_GET["idItem"];
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
$GRUPOS = [
  "TRANSPORTE",
  "NEUMATICOS",
  "CATALOGO",
  "PPCR",
  "STELLANTIS"
  ];
?>
<link rel="stylesheet" href="../css/style28.css" type="text/css" />
<link rel="stylesheet" href="../css/chechu.css" type="text/css" />
<form class='formNotebook' title="links">
  <label></label>
  <select type="text" placeholder="web" id="grupo">
    <option value="" selected disabled hidden></option>
    <?php foreach($GRUPOS as $grupo) {
      $selected = '';
          if($grupo == strtoupper(@$link[0][10])) { 
            $selected = 'selected';
          }
      ?>
      <option value="<?= $grupo ?>" <?= strtolower($selected) ?> ><?= $grupo ?></option>
    <?php } ?>
  </select>
  <label></label><input type='text' placeholder='Web' id='web' value="<?= @$link[0][9] ?>">
  <label></label><input type='text' placeholder='Nombre' id='marca' value="<?= @$link[0][1] ?>">
  <label></label>
    <select type='text' id='placa'>
      <option value="" selected>PLACA</option>
      <?php foreach ($PLACAS as $placa) { ?>
        <?php
          $selected = '';
          if($placa == @$link[0][2]) { 
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
  <label></label><div class="formPrivatePass"><label>Privado</label><input type='checkbox' id='private' title="Contraseña privada"></div>
  <label></label><input type='submit' id="<?= $id ?>" value='añadir'>
</form>
<script src="../js/form2.js?108"></script>