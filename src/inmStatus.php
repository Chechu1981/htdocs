<?php 
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
      <h1>Estadística inmovilizados</h1>
    </div>
    <div class="csv-files nocompleta">
      <section>
        <h2 style="text-align: center">Buscar referencias que bajan su prioridad</h2>
        <input type="text" name="ref" id="searchRef" placeholder="Referencia">
        <input type="text" name="cliente" id="searchClient" placeholder="Número de cliente">
        <input type="submit" id="btnSbmt" value="Buscar Referencia"></input>
        <hr style="margin-bottom: 15%">
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