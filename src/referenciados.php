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
    <div id="contacts" class="contacts" style="height:auto">
      <h1>Referenciados</h1>
      <button id="filtrado">Filtros</button>
    </div>
    <div class="csv-files nocompleta">
      <section id="placas">
        <div id="dropContainer" style="height: 130px">
        </div>
        <form action="#">
          <input type="file" name="csv-file" id="csvFile" style="display:none">
          <button type="submit">Calcular</button>
        </form>
        <hr/>
        <?php include_once '../api/getLastRef.php'; ?>
      </section>
      <div>
        <div id="slide-button-all" class="arrow-slider arrow-ref"><img src="../img/filter_alt_FILL0_wght400_GRAD0_opsz24.png" alt="arrow"></div>
        <div id="slide-button-short" class="arrow-slider arrow-ref"><img src="../img/table_rows_narrow_FILL0_wght400_GRAD0_opsz24.png" alt="arrow"></div>
      </div>
      <section id="resultRef"></section>
      <section id="completeRef" class="hidden"></section>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>