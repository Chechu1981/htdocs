<?php include('./../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include_once('../helper/head.php'); ?>
</head>
<body>
  <div id="menu">
    <?php include_once '../helper/menu.php'; ?>
  </div>
  <div class="search-table">
    <div id="contacts" class="contacts" >
      <h1>Inmovilizados</h1>
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
        <?php include_once '../api/getLastAssign.php'; ?>
      </section>
      <div id="slide-button" class="arrow-slider"><img src="../img/arrow_back_ios_FILL0_wght400_GRAD0_opsz24.png" alt="arrow"></div>
      <section id="result"></section>
      <section id="complete" class="hidden"></section>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>