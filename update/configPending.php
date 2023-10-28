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
                <button id="downloads">Ver descargas</button>
                <input type="submit" value="Actualizar" style="margin:10px;font-family: nunito, arial;background-color: var(--cards-border-color);color: var(--main-font-color);padding: 10px;border-radius: 8px;border: 1px solid var(--cards-active-color);cursor: pointer;box-shadow: 2px 2px var(--bg-font-color);">
            </form>
        </div>
        <div style="text-align: center;height: 16vh;"></div>
        
    </div>
    <?php include('../helper/footer.php'); ?>
</body>
</html>
<script>
  document.getElementById('downloads').addEventListener('click',()=>{
    window.open("../api/getIpClient.php","Clientes que descargan el fichero de pendientes","menubar=no, scrollbars=no, width=1000, height=900")
  })
</script>