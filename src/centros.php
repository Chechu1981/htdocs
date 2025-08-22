<?php include('../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('../helper/head.php'); ?>
</head>
<body>
  <?php include_once '../helper/alert.php'; ?>
  <?php include_once '../helper/menu.php'; ?>
  <div class="search-table">
      <div id="contacts">
        <h1>Centros</h1>
        <div id="search-line" class="nclient search-line search-focused">
          <span class="lupa">
            <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
            </svg>
          </span>
          <div class="textbox" id="search-box">
            <input type="search" id="search-contacts" placeholder="Buscar contacto...">
          </div>
        </div>
      </div>
      <div id="center-items">
          <ul>    
              <li><a href="<?php echo $src.'/src/center/central.php' ?>">Central</a></li>
              <li><a href="<?php echo $src.'/src/center/madrid.php' ?>">Madrid</a></li>
              <li><a href="<?php echo $src.'/src/center/sevilla.php' ?>">Sevilla</a></li>
              <li><a href="<?php echo $src.'/src/center/vigo.php' ?>">Santiago</a></li>
              <li><a href="<?php echo $src.'/src/center/granada.php' ?>">Málaga</a></li>
              <li><a href="<?php echo $src.'/src/center/zaragoza.php' ?>">Zaragoza</a></li>
              <li><a href="<?php echo $src.'/src/center/palma.php' ?>">Palma</a></li>
              <li><a href="<?php echo $src.'/src/center/paterna.php' ?>">Paterna</a></li>
              <li><a href="<?php echo $src.'/src/center/barcelona.php' ?>">Barcelona</a></li>
          </ul>
      </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>