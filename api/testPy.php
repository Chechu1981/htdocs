<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test de ejecuación Python</title>
</head>
<body>
  <?php
    $uri = $_SERVER['PHP_SELF'];
    $page = strtoupper(substr(explode("/",$uri)[count(explode("/",$uri))-1],0,-4));
    $src = ".";
    !strstr("$uri",'home') == '/home.php' ? $src = ".." : '';
    strpos($uri,'center') > 0 ? $src = "../.." : '';
    $data = file_get_contents($src.'/json/sesiones.json');
    $usr = json_decode($data, true);
    var_dump($usr);
  ?>
  <div id="resp"></div>
</body>
<script src="../js/test.js"></script>
</html>