<?php include('../../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('../../helper/head.php'); ?>
</head>
<body>
  <?php include_once '../../helper/alert.php'; ?>
  <?php include_once '../../helper/menu.php'; ?>
  <div class="search-table">
    <div id="contacts" class="contacts">
    <h1>Cesiones - Buscar</h1>
      <?php include_once '../../helper/menuCesiones.php'; ?>
    </div>
    <form id="search-ref" class="search-filter">
      <section class="-search">
        <label for="refAssign">Buscar</label>
        <input type="search" name="refAssign" id="refAssig" placeholder="Buscar..." style="margin-top:0;width:auto"></input>
      </section>
      <section class="-search">
        <label for="origen">Origen</label>
        <select id="origen" name="origen" aria-placeholder="Origen" style="margin-top:0">
          <option value=""></option>
          <option value="MADRID">Madrid</option>
          <option value="SANTIAGO">Santiago</option>
          <option value="BARCELONA">Barcelona</option>
          <option value="ZARAGOZA">Zaragoza</option>
          <option value="VALENCIA">Valencia</option>
          <option value="MÁLAGA">Málaga</option>
          <option value="SEVILLA">Sevilla</option>
          <option value="PALMA">Palma</option>
          <option value="MAT">Mister-auto</option>
          <option value="EXT">Compra externa</option>
        </select>
      </section>
      <section class="-search">
        <label for="destino">Destino</label>
        <select id="destino" name="destino" aria-placeholder="Destino" style="margin-top:0">
          <option value=""></option>
          <option value="MADRID">Madrid</option>
          <option value="SANTIAGO">Santiago</option>
          <option value="BARCELONA">Barcelona</option>
          <option value="ZARAGOZA">Zaragoza</option>
          <option value="VALENCIA">Valencia</option>
          <option value="MÁLAGA">Málaga</option>
          <option value="SEVILLA">Sevilla</option>
          <option value="PALMA">Palma</option>
        </select>
      </section>
      <section class="-search">
        <label for="seguro" title="Asegurado por Disgón o Logística">🔒</label>
        <input type="checkbox" id="seguro" name="seguro" title="Asegurado por Disgón o Logística" style="margin-top:0"></input>
      </section>
      <section class="-search">
        <label for="fecha">Buscar</label>
        <input type="submit" style="margin-top:0" value="Buscar"></input>
      </section>
    </form>
    <div id="cesiones"></div>
  </div>
  <?php include('./../../helper/footer.php'); ?>
</body>
</html>