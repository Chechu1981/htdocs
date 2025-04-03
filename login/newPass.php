<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <link rel="stylesheet" href="../css/login.css">
    <script type="text/javascript" src="../js/newPass.js" defer></script>   
    <title>PPCR (Placa de Piezas y Componentes de Recambio)</title>
</head>
<body>
    <div class="mainBox">
        <div class="logoBox"><img src="../img/Logo-PPCR-2022.png" alt="Logo PPCR"></div>
        <div class="loginBox">
            <h1>Nueva</h1>
            <form action="./home.php" method="POST" id="loginForm">
                <input type="password" name="psw1" id="psw1" placeholder="contraseña" required>
                <input type="password" name="psw2" id="psw2" placeholder="repetir contraseña" required>
                <input type="submit" value="Reestablecer">
            </form>
            <div class="errorBox" id="errorBox">
                <p id="errorText">Mínimo 8 caracteres</p>
            </div>
        </div>
    </div>
</body>
</html>