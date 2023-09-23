<?php include('./../helper/logon.php'); ?>
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
        <div id="contacts">
            <h1>Configuración - Pendientes</h1>
        </div>
        <div>
            <div id="dropContainer">
                Arrastra aquí el fichero
            </div>
            <form style="text-align: center">
                <input type="file" name="pending" id="pending" style="display:none">
                <input type="submit" value="Actualizar" style="font-size: xx-large;margin:10px">
            </form>
        </div>
        <button id="downloads">Ver descargas</button>
    </div>
    <?php include('../helper/footer.php'); ?>
</body>
</html>
<script>
  document.getElementById('downloads').addEventListener('click',()=>{
    window.open("../api/getIpClient.php","Clientes que descargan el fichero de pendientes","menubar=no, scrollbars=no, width=1000, height=900")
  })
</script>