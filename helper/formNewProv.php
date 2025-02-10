
<!DOCTYPE html>
<html lang="es">
<head>
  <?php 
  include('./../helper/logon.php');
  include_once '../connection/data.php';
  $contacts = new Contacts();
  //$rows = $contacts->newUser();
  ?>
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
            <label for="nombre">NOMBRE DE LA PLACA</label>
              <input type="username" id="nombre" placeholder="Nombre de la placa" value="">
            <label for="email">CORREO ELECTRÓNICO</label>
              <input type="text" id="email" placeholder="Correo electrónico" value="" autocomplete="off">
            <label for="direccion">DIRECCIÓN</label>
                <input name="direccion" id="direccion" placeholder="Dirección"></input>
            <label for="nprov">NÚMERO DE PROVEEDOR</label>
              <input type="number" id="nprov" placeholder="Número de proveedor" value="" autocomplete="off">
            <label for="btnform"></label><input type="submit" value="Crear" id="btnform">
        </form>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>
