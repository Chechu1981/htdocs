<?php
$PLACAS = [
  "MADRID",
  "SEVILLA",
  "SANTIAGO",
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
    <option value=""></option>
    <option value="transporte">TRANSPORTE</option>
    <option value="neumaticos">NEUMÁTICOS</option>
    <option value="catalogo">CATÁLOGO</option>
    <option value="ppcr">PPCR</option>
    <option value="stellantis">STELLANTIS</option>
  </select>
  <label></label><input type='text' placeholder='Web' id='web'>
  <label></label><input type='text' placeholder='Nombre' id='marca'>
  <label></label>
    <select type='text' placeholder='placa' id='placa'>
      <option value=""></option>
      <?php foreach ($PLACAS as $placa) { ?>
        <option value="$placa"><?= $placa ?></option>
      <?php } ?>
    </select>
  <label></label><input type='text' placeholder='Cuenta' id='cuenta'>
  <label></label><input type='text' placeholder='Usuario' id='usuario'>
  <label></label><input type='text' placeholder='Contrsaeña' id='paswd'>
  <label></label><input type='text' placeholder='Teléfono' id='phone'>
  <input type='submit' value='añadir'>
</form>
<script src="../js/form2.js?108"></script>