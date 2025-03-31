<?php include('./../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('./../helper/head.php'); ?>
</head>
<body>
  <?php include_once '../helper/alert.php'; ?>
  <div id="menu">
    <?php include_once '../helper/menu.php'; ?>
  </div>
  <div class="search-table">
    <div id="contacts" class="contacts">
      <h1>Baterías Eurorepar</h1>
    </div>
    <div id="filter" class="filter-oil">
      <section style="display:flex;flex-direction:column;align-items:center">
        <label for="amperios" id="lblAmp" style="font-size:large">Amperios 71 - 81</label>
        <input type="range" name="amperios" id="amperios" min="30" max="120" style="width:300px" list="markers">
        <datalist id="markers" style="display: flex;flex-direction: column;justify-content: space-between;writing-mode: vertical-lr;width: 300px;">
          <option value="30" label="30" style="transform: rotate(270deg);"></option>
          <option value="40" label="40" style="transform: rotate(270deg);"></option>
          <option value="51" label="50" style="transform: rotate(270deg);"></option>
          <option value="63" label="60" style="transform: rotate(270deg);"></option>
          <option value="74" label="70" style="transform: rotate(270deg);"></option>
          <option value="85" label="80" style="transform: rotate(270deg);"></option>
          <option value="96" label="90" style="transform: rotate(270deg);"></option>
          <option value="108" label="110" style="transform: rotate(270deg);"></option>
          <option value="120" label="todo" style="transform: rotate(270deg);"></option>
        </datalist>
      </section>
      <section style="display:flex;flex-direction:column;align-items: flex-end">
        <div class=".form-group">
          <label for="s&s" style="margin: 8px 0 0 20px;font-size: large;">Stop & Start</label>
          <input type="checkbox" name="s&s" id="s&s" style="    width: 25px;height: 25px;margin: 8px 0 0 20px;">
        </div>
        <div>
          <label for="s&s" style="margin: 8px 0 0 20px;font-size: large;">Normal</label>
          <input type="checkbox" name="s&s" id="normal" style="    width: 25px;height: 25px;margin: 8px 0 0 20px;">
        </div>
      </section>
    </div>
    <div id="bat_items">
      <?php
      include_once '../api/getBateria.php';
      ?>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>