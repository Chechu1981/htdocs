<?php include('./../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include('./../helper/head.php'); ?>
</head>
<body>
    <?php include_once '../helper/alert.php'; ?>
    <div id="menu">
        <?php include_once '../helper/menu.php'; ?>
    </div>
    <div class="search-table">
        <div id="contacts">
            <h1>Configuración -</h1><h1> Actualización de Tarifa</h1>
        </div>
        <div>
            <div id="dropContainer">
                Arrastra aquí el fichero
            </div>
            <form style="text-align: center">
                <input type="file" name="pending" id="pending" style="display:none">
                <input type="submit" value="Actualizar" style="font-size: xx-large;margin:10px">
            </form>
            <div id="panel" style="font-size: xx-large;text-align: center;"></div>
        </div>
    </div>
    <?php include('../helper/footer.php'); ?>
</body>
</html>