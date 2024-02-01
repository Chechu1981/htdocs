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
      <h1>Libreta</h1>
      <div id="search-line" class="nclient search-line search-focused">
        <span class="lupa">
          <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
          </svg>
        </span>
        <div class="textbox" id="search-box">
          <input type="search" id="search-contacts" placeholder="Buscar notas...">
        </div>
      </div>
    </div>
    <div id="contacts-items">
      <div id="center-items-pass" class="bottons">
        <ul class="header-title" style="width:60%;margin:auto;">    
            <li title="CALENDARIO">CALENDARIOS</li>
            <li title="ACEITE">ACEITE</li>
            <li title="CITROEN">CITROEN / PEUGEOT</li>
            <li title="EUROREPAR">EUROREPAR</li>
            <li title="OPEL">OPEL / CHEVROLET</li>
            <li title="FIAT/JEEP">FIAT / JEEP</li>
            <li title="DOCUMENTOS">DOCUMENTOS</li>
        </ul>
      </div>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>