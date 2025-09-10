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
      <div id="clientName" class="clientName form-extBuy" style="grid-template-columns: 20% 70%;">
        <label for="placa" style="display: none;"></label>
        <select type="text" id="placa" placeholder="Buscar pedido...">
          <option value="">Selecciona una placa</option>
          <option value="MADRID">MADRID</option>
          <option value="SANTIAGO">SANTIAGO</option>
          <option value="BARCELONA">BARCELONA</option>
          <option value="ZARAGOZA">ZARAGOZA</option>
          <option value="VALENCIA">VALENCIA</option>
          <option value="MÁLAGA">MÁLAGA</option>
          <option value="SEVILLA">SEVILLA</option>
          <option value="PALMA">PALMA</option>
        </select>
        <label for="busqueda" style="display: none;"></label>
        <input type="text" id="busqueda" style="text-align: left;" placeholder="Buscar pedido...">
      </div>
      <div class="listOrderExt" id="search-results">
        <?php include_once '../../api/getExtAllOrders.php'; ?>
      </div>
    </div>
  </div>
  <?php include('../../helper/footer.php'); ?>
</body>
</html>