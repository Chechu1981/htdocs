
<?php include_once ('./../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('./../helper/head.php'); ?>
</head>
<body>
  <?php include_once '../helper/alert.php'; ?>
  <?php include_once '../helper/menu.php'; ?>
  <div class="search-table">
    <div id="contacts" class="contacts">
      <h1>Proveedores externos</h1>
      <button id="newUser">Nuevo proveedor</button>
    </div>
    <div class="split-screen">
      <div class="barra_lateral">
        <div id="buttons_plates">
          <span class="btn">MADRID</span>
          <span class="btn">BARCELONA</span>
          <span class="btn">ZARAGOZA</span>
          <span class="btn">VALENCIA</span>
          <span class="btn">GRANADA</span>
          <span class="btn">PALMA</span>
          <span class="btn">SANTIAGO</span>
          <span class="btn">VALENCIA</span>
        </div>
      </div>
      <div id="prov-list" class="search-table" style="padding-left: 35px;">
        <?php include '../api/getProvList.php'; ?>
      </div>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>
