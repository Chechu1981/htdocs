
<!DOCTYPE html>
<html lang="es">
<head>
  <?php 
  include('./../helper/logon.php');
  include_once '../connection/data.php';
  $contacts = new Contacts();
  $userData = $contacts->getProvById($_GET['userId']);
  $lista = [
    'ADV',
    'MADRID',
    'SANTIAGO',
    'BARCELONA',
    'ZARAGOZA',
    'VALENCIA',
    'GRANADA',
    'BARCELONA',
    'PALMA',
    'DESBORDE',
    'PLATAFORMAS',
    'SEVILLA'
    ]
  ?>
</head>
<body>
  <div id="menu">
    <?php include_once '../helper/menu.php'; ?>
  </div>
  <div class="search-table">
    <div id="contacts" class="contacts">
      <h1>Usuarios - Configuración</h1>
      <button id="userList">Lista de Usuarios</button>
    </div>
    <div class="note-body">
        <form action="" method="post" title="update">
            <label for="nombre">NOMBRE DE USUARIO</label>
              <input type="username" id="nombre" placeholder="Nombre de proveedor" value="<?= $userData[0][2] ?>">
            <label for="email">CORREO ELECTRÓNICO</label>
              <input type="text" id="email" placeholder="Correo electrónico" value="<?= $userData[0][4] ?>" autocomplete="off">
            <label for="direccion">DIRECCIÓN</label>
                <input name="direccion" id="direccion" value="<?= $userData[0][3] ?>">
            <label for="nprov">Número de proveedor</label>
              <input type="nprov" id="nprov" placeholder="Número de proveedor" value="<?= $userData[0][1] ?>" autocomplete="off">
            <label for="btnform"></label><input type="submit" value="Modificar" id="btnform">
        </form>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>
