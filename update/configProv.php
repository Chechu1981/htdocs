
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
    <div class="users">
        <?php include '../api/getProvList.php'; ?>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>
