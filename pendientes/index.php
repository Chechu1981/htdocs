<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <link rel="stylesheet" href="./css/login.css">
    <script type="text/javascript" src="./js/login.js" defer></script>   
    <script type="text/javascript" src="./js/pending.js" defer></script>   
    <title>PPCR (Placa de Piezas y Componentes de Recambio)</title>
</head>
<body>
    <div class="header">
        <img src="./img/ppcr.jpg" alt="PPCR">
    </div>
    <div class="top">
        <img src="./img/user-128.png" alt="user">
        <form>
            <input id="user" type="text"><label for="user">Usuario</label>
            <input id="pass" type="password"><label for="pass">Contraseña</label>
            <input type="submit" value="Entrar">
        </form>
    </div>
    <div id="msg" class="error"></div>
    <div class="cuadro">
        <h2>Listado de pedidos pendientes PPCR España</h2>
        Fecha de edición <?php echo date("d/m/Y g:i a") ?>
        <form>
            <label for="placa">Placa PPCR</label>
            <select name="placa" id="placa">
                <option value="MADRID">Madrid</option>
                <option value="SEVILLA">Sevilla</option>
                <option value="VIGO">Vigo</option>
                <option value="GRANADA">Granada</option>
                <option value="ZARAGOZA">Zaragoza</option>
                <option value="PALMA">Palma</option>
                <option value="PATERNA">Paterna</option>
                <option value="BARCELONA">Barcelona</option>
            </select>
            <label for="cliente">Cliente</label>
            <input type="text">
            <label for="referencia">Referencia</label>
            <input type="text">
            <input type="submit" value="Consultar">
        </form>
        <div id="items"></div>
    </div>
    <div id="items"></div>
</body>
</html>