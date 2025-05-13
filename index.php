<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de gestión de piezas y componentes de recambio. PPCR.">
    <meta name="keywords" content="PPCR, piezas, componentes, recambio, gestión, sistema, inventario">
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <link rel="stylesheet" href="./css/login.css?102">
    <script type="text/javascript" src="./js/login.js?101" defer></script>   
    <title>PPCR (Placa de Piezas y Componentes de Recambio)</title>
</head>
<body>
    <div class="mainBox">
        <div class="logoBox"><img src="./img/Logo-PPCR-2022.png" alt="Logo PPCR"></div>
        <div class="loginBox">
            <h1>Bienvenido</h1>
            <form action="./home.php" method="POST" id="loginForm">
                <input type="text" name="usr" id="usr" placeholder="Usuario" required autocomplete="current-password">
                <input type="password" name="psw" id="psw" placeholder="Contraseña" required autocomplete="current-password">
                <input type="submit" value="Iniciar Sesión">
            </form>
            <div class="errorBox" id="errorBox">
                <p id="errorText"></p>
            </div>
            <a href="./login/forgotPass.php" target="_self" rel="noopener noreferrer">He olvidado mi contraseña</a>
        </div>
    </div>
</body>
</html>