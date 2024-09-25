<?php
include_once './connection/data.php';
$contacts = new Contacts();
$date = $contacts->getDatePending();
$date = date_create($date[0][0]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Listado de referencias pendientes de servir de clientes de PPCR">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="apple-touch-icon" sizes="57x57" href="../img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png">
    <link rel="manifest" href="../img/favicon/manifest.json" />
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <link rel="stylesheet" href="./css/login1.css?123">
    <script type="text/javascript" src="./js/login.js" defer></script>   
    <script type="text/javascript" src="./js/pending.js" defer></script>   
    <title>PPCR (Placa de Piezas y Componentes de Recambio) Consulta de pendientes</title>
</head>
<body>
    <div class="logo">
        <img width="130px" height="79px" src="./img/Logo-PPCR-2022.png" alt="PPCR">
    </div>
    <div class="top">
        <img width="39px" height="39px" src="./img/user-128.png" alt="user">
        <form>
            <input id="user" type="text" name="password"><label for="user">Usuario</label>
            <input id="pass" type="password" name="password" autocomplete="on"><label for="pass">Contraseña</label>
            <input type="submit" value="Entrar">
            <div id="msg" class="error"></div>
        </form>
    </div>
    <div class="cuadro">
        <h2>Listado de pedidos pendientes PPCR España</h2>
        Última actualización:  <?php echo date_format($date, "d/m/Y H:i"); ?>
        <form>
            <label for="placa" style="transform:translate(0px, 0px)">Placa PPCR</label>
            <label for="cliente">Cliente</label>
            <label for="envio"></label>
            <label for="referencia">Referencia</label>
            <label style="color:transparent;transform: translate(19px, 18px);">.</label>
            <select name="placa" id="placa">
                <option value="MADRID">Madrid</option>
                <option value="SEVILLA">Sevilla</option>
                <option value="VIGO">Vigo</option>
                <option value="GRANADA">Granada</option>
                <option value="ZARAGOZA">Zaragoza</option>
                <option value="PALMA">Palma</option>
                <option value="VALENCIA">Paterna</option>
                <option value="BARCELONA">Barcelona</option>
            </select>
            <input placeholder="Nº cliente" type="number" id="cliente">
            <input placeholder="D. envío" type="number" id="envio">
            <input placeholder="Referencia" type="text" id="referencia">
            <input type="submit" value="Consultar">
        </form>
        <div id="items"></div>
    </div>
    <footer>
    <div>
       Placas de Piezas y Componentes de Recambio PPCR <?php echo getdate()['year']; ?>
    </div>
</footer>
</body>
</html>