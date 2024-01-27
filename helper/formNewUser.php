<?php 
include('./../helper/logon.php');
include_once '../connection/data.php';
$contacts = new Contacts();
//$rows = $contacts->newUser();
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
      <h1>Usuarios - Configuración</h1>
    </div>
    <div class="note-body">
        <form action="" method="post" title="update">
            <label>NOMBRE DE USUARIO</label>
                <input type="username" id="nombre" placeholder="Nombre" value="">
            <label>PUESTO</label>
                <select name="puesto" id="puesto">
                    <option value="ADV">ADV</option>
                    <option value="MADRID">MADRID</option>
                    <option value="VIGO">VIGO</option>
                    <option value="BARCELONA">BARCELONA</option>
                    <option value="ZARAGOZA">ZARAGOZA</option>
                    <option value="VALENCIA">VALENCIA</option>
                    <option value="GRANADA">GRANADA</option>
                    <option value="SEVILLA">SEVILLA</option>
                    <option value="PALMA">PALMA</option>
                    <option value="DESBORDE">DESBORDE</option>
                    <option value="PLATAFORMAS">PLATAFORMAS</option>
                </select>
            <label>CONTRASEÑA</label>
                <input type="password" id="pass1" placeholder="Contraseña" value="" autocomplete="">
            <label>REPETIR CONTRASEÑA</label>
                <input type="password" id="pass2" placeholder="Repetir contraseña" value="" autocomplete="">
            <label></label><input type="submit" value="Crear">
        </form>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>
