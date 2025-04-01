<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="confirmar_contraseña.php" method="post">
    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" required><br><br>
    
    <label for="new_password">Nueva contraseña:</label>
    <input type="password" id="new_password" name="new_password" required><br><br>
    
    <label for="confirm_password">Confirmar nueva contraseña:</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br><br>
    
    <input type="submit" value="Enviar">
  </form>
</body>
</html>