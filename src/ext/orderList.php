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
    <h1>Compra externa - Pedidos</h1>
      <?php include_once '../../helper/menuExt.php'; ?>
    </div>
    <div>
      <div id="clientName" class="clientName">
        <label for="placa"></label>
        <input type="text" placeholder="Buscar pedido...">
        <label for="proveedor"></label>
        <input type="text" placeholder="Buscar proveedor...">
      </div>
      <div class="listOrderExt" id="search-results">
        <?php
        include_once '../../api/getExtAllOrders.php';
        ?>
      </div>
    </div>
  </div>
  <?php include('../../helper/footer.php'); ?>
</body>
</html>