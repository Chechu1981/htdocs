<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('./../helper/logon.php'); ?>
</head>
<body>
  <div id="menu">
    <?php include_once '../helper/menu.php'; ?>
  </div>
  <div class="search-table">
    <div id="contacts" class="contacts">
      <h1>Aceite</h1>
    </div>
    <div id="filter" class="filter-oil">
      <ul class="header-title">
        <li title="visco_0W20">0W20</li>
        <li title="visco_0W30">0W30</li>
        <li title="visco_5W20">5W20</li>
        <li title="visco_5W30">5W30</li>
        <li title="visco_10W40">10W40</li>
        <li title="visco_15W40">15W40</li>
        <li title="visco_ACEITE">OTROS</li>
      </ul>
      <ul class="header-title">
        <li title="vol_1">1L</li>
        <li title="vol_5">5L</li>
        <li title="vol_20">20L</li>
        <li title="vol_60">60L</li>
        <li title="vol_208">208L</li>
        <li title="vol_GRANEL">GRANEL</li>
      </ul>
      <ul class="header-title">
        <li title="marca_TOTAL">TOTAL</li>
        <li title="marca_EUROREPAR">EUROREPAR</li>
      </ul>
    </div>
    <div id="oil_items" class="bottons-oil"></div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>