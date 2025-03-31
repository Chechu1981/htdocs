<?php include('../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('../helper/head.php'); ?>
</head>
<body>
  <?php include_once '../helper/alert.php'; ?>
  <div id="menu">
    <?php include_once '../helper/menu.php'; ?>
  </div>
  <div class="search-table">
    <div id="contacts" class="contacts">
      <h1>Cesiones - Todas</h1>
        <?php include_once '../helper/menuCesiones.php'; ?>
      </div>
    <div id="cesiones"></div>
  </div>
  <?php include('./../helper/footer.php'); ?>
</body>
</html>