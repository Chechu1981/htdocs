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
      <h1>Cesiones - En curso</h1>
      <?php include_once '../../helper/menuCesiones.php'; ?>
      <select name="filterAssiigns" id="filterAssiigns">
        <option value="<?= $_COOKIE['user'] ?>"><?= $_COOKIE['user'] ?></option>
        <option value="<?= $_COOKIE['puesto'] ?>"><?= $_COOKIE['puesto'] ?></option>
      </select>
    </div>
    <div id="cesiones"></div>
  </div>
  <?php include('./../../helper/footer.php'); ?>
</body>
</html>