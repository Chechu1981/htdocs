<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('../../helper/logon.php'); ?>
</head>
<body>
  <?php include_once '../../helper/alert.php'; ?>
  <div id="menu">
    <?php include_once '../../helper/menu.php'; ?>
  </div>
  <div class="search-table">
    <div id="contacts" class="contacts">
    <h1>Cesiones - Buscar</h1>
      <?php include_once '../../helper/menuCesiones.php'; ?>
    </div>
    <div class="search-filter">
      <section class="-search">
        <label for="origen">Origen</label>
        <select id="origen" name="origen" aria-placeholder="Origen">
          <option value=""></option>
          <option value="MADRID">Madrid</option>
          <option value="SANTIAGO">Santiago</option>
          <option value="BARCELONA">Barcelona</option>
          <option value="ZARAGOZA">Zaragoza</option>
          <option value="VALENCIA">Valencia</option>
          <option value="GRANADA">Granada</option>
          <option value="SEVILLA">Sevilla</option>
          <option value="PALMA">Palma</option>
          <option value="MAT">Mister-auto</option>
          <option value="EXT">Compra externa</option>
        </select>
      </section>
      <section class="-search">
        <label for="destino">Destino</label>
        <select id="destino" name="destino" aria-placeholder="Destino">
          <option value=""></option>
          <option value="MADRID">Madrid</option>
          <option value="SANTIAGO">Santiago</option>
          <option value="BARCELONA">Barcelona</option>
          <option value="ZARAGOZA">Zaragoza</option>
          <option value="VALENCIA">Valencia</option>
          <option value="GRANADA">Granada</option>
          <option value="SEVILLA">Sevilla</option>
          <option value="PALMA">Palma</option>
          <option value="MAT">Mister-auto</option>
          <option value="EXT">Compra externa</option>
        </select>
      </section>
      <section class="-search">
        <label for="seguro" title="Asegurado por Disgón o Logística">🔒</label>
        <input type="checkbox" id="seguro" name="seguro" title="Asegurado por Disgón o Logística"></input>
      </section>
    </div>
    <div id="search-line" class="nPass search-line search-focused">
      <span class="lupa">
        <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
        </svg>
      </span>
      <div class="textbox" id="search-box">
        <form id="search-ref">
          <input type="search" id="refAssig" placeholder="Buscar a cholón">
        </form>
      </div>
    </div>
    <div id="cesiones"></div>
  </div>
  <?php include('./../../helper/footer.php'); ?>
</body>
</html>