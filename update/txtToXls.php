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
        <div id="contacts">
            <h1>Configuración</h1>
            <h1>Conversor de tarifa txt a excel</h1>
        </div>
        <div>
            <div id="dropContainer">
                Arrastra aquí el fichero
            </div>
            <form style="text-align: center">
                <input type="file" name="pending" id="pending" style="display:none">
                <input type="submit" value="Convertir a excel" style="font-size: xx-large;margin:10px">
            </form>
        </div>
    </div>
    <?php include('../helper/footer.php'); ?>
</body>
</html>