<?php include_once ('./../helper/logon.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <?php 
  include('./../helper/head.php');
  $userData = $contacts->getUserById($_GET['userId']);
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
              <input type="username" id="nombre" placeholder="Nombre de usuario" value="<?= $userData[0][1] ?>">
            <label for="email">CORREO ELECTRÓNICO</label>
              <input type="email" id="email" placeholder="Correo electrónico" value="<?= $userData[0][6] ?>" autocomplete="off">
            <label for="puesto">PUESTO</label>
                <select name="puesto" id="puesto" value="<?= $userData[0][4] ?>">
                <?php foreach ($lista as $equipo) { ?>
                  <?php if ($equipo == $userData[0]['puesto']) { ?>
                    <option value="<?= $equipo ?>" selected ><?= $equipo ?></option>
                    <?php } else { ?>
                      <option value="<?= $equipo ?>"><?= $equipo ?></option>
                    <?php } ?>
                <?php } ?>
                </select>
            <label for="pass1">CONTRASEÑA</label>
              <input type="password" id="pass1" placeholder="Contraseña" value="<?= $userData[0][2] ?>" autocomplete="off">
            <label for="pass2">REPETIR CONTRASEÑA</label>
              <input type="password" id="pass2" placeholder="Repetir contraseña" value="<?= $userData[0][2] ?>" autocomplete="off">
            <label for="btnform"></label><input type="submit" value="Modificar" id="btnform">
        </form>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>
