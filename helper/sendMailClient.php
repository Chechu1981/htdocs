<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Cliente</title>
</head>
<body>
  <form method="post" style="justify-items: center;overflow: auto;">
    <label for="clientNumber">Nº Cliente:</label>
    <input type="number" id="clientNumber" name="clientNumber" required>
    <input type="submit" value="Buscar" id="btnBuscar">
  </form>
  <div id="resultado" style="height:337px"></div>
</body>
</html>