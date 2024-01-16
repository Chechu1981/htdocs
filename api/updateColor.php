<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$userFilds = $contacts->getUserBySessid($_POST['userId']);
$usr = $userFilds[0][1];

$h = $_POST['h'];
$s = $_POST['s'];
$l = $_POST['l'];

$cssFile = ":root{
  --main-font-color: hsl($h, $s%, $l%);
  --second-bg-color: hsl($h, ".($s - 30)."%, ".($l + 25)."%);
  --search-line: hsla($h, ".($s - 14)."%,".($l + 35)."%, 1);
  --cards-border-color: hsl($h, ".($s + 20)."%, ".($l + 50)."%);
  --cards-active-color: hsl($h, ".($s + 23)."%, ".($l + 27)."%);
  --bg-body-color: hsl($h, ".($s - 57)."%, ".($l + 67)."%);
  --bg-font-color: hsl($h, ".($s + 1)."%, ".($l - 22)."%);
  --invert-img-filter: invert(0);
  }";

$fh = fopen('../css/'.strtolower($usr).'.css', 'w') or die ('Ocurrió un error');
$texto = fgets($fh);
fseek($fh, 0 , SEEK_END);
fwrite($fh,$cssFile) or die ("No se puede escribir el archivo");
fclose($fh);

echo "Colores cambiados con éxito";