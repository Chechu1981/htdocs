<?php include('./../helper/logon.php'); 
$botones = array(
  'TODOS',
  'BALEARES',
  'GRANADA',
  'MADRID',
  'PATERNA',
  'SEVILLA',
  'VIGO',
  'ZARAGOZA'
);
?>
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
    <div id="contacts" class="contacts">
      <h1>Estadística inmovilizados</h1>
    </div>
    <div class="csv-files nocompleta">
      <section>
        <?php
        foreach ($botones as $btn){
        ?>
        <button value="<?php echo strtolower($btn); ?>"><?php echo $btn; ?></button>
        <?php } ?>
      </section>
      <div></div>
      <section id="result"></section>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>