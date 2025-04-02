<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <link rel="stylesheet" href="./css/login.css">
    <script type="text/javascript" src="./js/loginTest.js" defer></script>   
    <title>PPCR (Placa de Piezas y Componentes de Recambio)</title>
</head>
<body>
    <div class="mainBox">
        <div class="logoBox"><img src="./img/Logo-PPCR-2022.png" alt="Logo PPCR"></div>
        <div class="loginBox">
            <h1>Recuperar contraseña</h1>
            <form action="#">
              <input type="text" name="mail" id="mail" placeholder="usuario@stellantis.com" required>
              <input type="submit" value="Enviar contraseña provisional al correo">
            </form>
            <input type="text" name="passrecovery" id="passrecovery" placeholder="XXXXX" required>
            <div class="errorBox" id="errorBox">
                <p id="errorText"></p>
            </div>
        </div>
    </div>
</body>
</html>