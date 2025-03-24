<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('../../helper/logon.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <?php include_once '../../helper/alert.php'; ?>
  <div id="menu">
    <?php include_once '../../helper/menu.php'; ?>
  </div>
  <div class="search-table">
    <div id="contacts" class="contacts">
      <h1>Cesiones - Estadística</h1>
      <?php include_once '../../helper/menuCesiones.php'; ?>
    </div>
    <div id="cesiones" style="display: block;">
      <div style="margin: auto;height: calc(70vh - 100px);width: calc(100% - 100px);">
        <canvas id="myChart"></canvas>
      </div>
      <hr style="margin-top: 40px;">
      <div id="piden" style="margin: auto;height: calc(70vh - 100px);width: calc(100% - 100px);">
        <canvas id="chartPiden"></canvas>
      </div>
      <hr style="margin-top: 40px;">
      <div id="ceden" style="margin: auto;height: calc(70vh - 100px);width: calc(100% - 100px);">
        <canvas id="chartCeden"></canvas>
      </div>
    </div>
  </div>
  <?php include('./../../helper/footer.php'); ?>
</body>
</html>