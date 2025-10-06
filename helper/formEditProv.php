<?php include_once ('./../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php 
  include('./../helper/head.php');
  $userData = $contacts->getProvById($_GET['userId']);
  $tipo = ['IAM', 'OEM'];
  $lista = [
    'MADRID',
    'SANTIAGO',
    'BARCELONA',
    'ZARAGOZA',
    'VALENCIA',
    'MÁLAGA',
    'PALMA',
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
      <h1>Proveedores - Configuración</h1>
      <button id="userList">Lista de Proveedores</button>
    </div>
    <div class="note-body">
      <form action="" method="post" title="update">
          <label for="nombre">NOMBRE DE PROVEEDOR</label>
            <input type="username" id="nombre" placeholder="Nombre de proveedor" value="<?= $userData[0][1] ?>">
          <label for="email">CORREO ELECTRÓNICO</label>
            <input type="text" id="email" placeholder="Correo electrónico" value="<?= $userData[0][5] ?>" autocomplete="off">
          <label for="direccion">DIRECCIÓN</label>
              <input name="direccion" id="direccion" placeholder="Dirección" value="<?= $userData[0][6] ?>">
          <label for="tlf">TELÉFONO</label>
              <input name="tlf" id="tlf" placeholder="Teléfono" value="<?= $userData[0][4] ?>">
          <label for="marca">MARCA</label>
              <input name="marca" id="marca" placeholder="Marca" value="<?= $userData[0][2] ?>">
          <label for="tipo">TIPO</label>
            <select name="tipo" id="tipo">
              <?php foreach($tipo as $item): ?>
                <option value="<?= $item ?>" <?= ($userData[0][3] == $item) ? 'selected' : '' ?>><?= $item ?></option>
              <?php endforeach; ?>
            </select>
          <label for="placa">PLACA</label>
            <select name="placa" id="placa">
              <?php foreach ($lista as $equipo) { ?>
                <?php if ($equipo == $userData[0]['placa']) { ?>
                  <option value="<?= $equipo ?>" selected ><?= $equipo ?></option>
                  <?php } else { ?>
                    <option value="<?= $equipo ?>"><?= $equipo ?></option>
                  <?php } ?>
              <?php } ?>
            </select>
          <label for="recogida">RECOGIDA</label>
              <input type="checkbox" name="recogida" id="recogida" <?= ($userData[0]['recogida'] == 'S') ? 'checked' : '' ?>>
          <label for="btnform"></label><input type="submit" value="Modificar" id="btnform">
      </form>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>
