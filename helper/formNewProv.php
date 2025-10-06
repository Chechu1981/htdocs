
<?php include('./../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('./../helper/head.php'); ?>
</head>
<body>
  <div id="menu">
    <?php include_once '../helper/menu.php'; ?>
  </div>
  <div class="search-table">
    <div id="contacts" class="contacts">
      <h1>Proveedores - Configuración</h1>
      <button id="userList">Lista de proveedores</button>
    </div>
    <div class="note-body">
        <form action="" method="post" title="update">
          <label for="placa">NOMBRE DE LA PLACA</label>
            <select name="placa" id="placa">
              <option value="" disabled selected>Selecciona una placa</option>
              <option value="MADRID">MADRID</option>
              <option value="BARCELONA">BARCELONA</option>
              <option value="VALENCIA">VALENCIA</option>
              <option value="SEVILLA">SEVILLA</option>
              <option value="ZARAGOZA">ZARAGOZA</option>
              <option value="MALAGA">MALAGA</option>
              <option value="GALICIA">GALICIA</option>
              <option value="PALMA">PALMA</option>
            </select>
          <label for="nombre">NOMBRE DEL PROVEEDOR</label>
            <input type="text" id="nombre" placeholder="Nombre del proveedor" value="" autocomplete="off">
          <label for="nprov">NÚMERO DE PROVEEDOR ICAR</label>
            <input type="number" id="nprov" placeholder="Número de proveedor" value="" autocomplete="off">
          <label for="marca">MARCA</label>
            <input type="text" id="marca" placeholder="Marca" value="">
          <label for="tipo">TIPO</label>
            <select name="tipo" id="tipo">
              <option value="" disabled selected>Selecciona un tipo</option>
              <option value="OEM">RECAMBIO ORIGINAL</option>
              <option value="IAM">RECAMBIO ALTERNATIVO</option>
            </select>
          <label for="email">CORREO ELECTRÓNICO</label>
            <input type="text" id="email" placeholder="Correo electrónico" value="" autocomplete="off">
          <label for="tlf">TELÉFONO</label>
            <input type="text" id="tlf" placeholder="Teléfono" value="" autocomplete="off">
          <label for="direccion">DIRECCIÓN</label>
              <input name="direccion" id="direccion" placeholder="Dirección"></input>
          <label for="entrega">ENTREGA EN EL PROVEEDOR</label>
            <input type="checkbox" id="entrega" value="" autocomplete="off">
          <label for="btnform"></label><input type="submit" value="Crear" id="btnform">
        </form>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>
