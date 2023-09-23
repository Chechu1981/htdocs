<?php
include_once '../connection/data.php';

$contacts = new Contacts();
$user = $contacts->getUserBySessid($_GET['id']);


$scripts = (object)[
  'CENTRAL' => "/js/center.js",
  'MADRID' => "/js/center.js",
  'BARCELONA' => "/js/center.js",
  'PATERNA' => "/js/center.js",
  'SEVILLA' => "/js/center.js",
  'GRANADA' => "/js/center.js",
  'PALMA' => "/js/center.js",
  'ZARAGOZA' => "/js/center.js",
  'VIGO' => "/js/center.js",
  'CENTROS' => "/js/center.js",
  'CESIONES' => "/js/cesiones14.js",
  'CESIONESTEST' => "/js/cesionestest.js",
  'LIBRETA' => "/js/libreta.js",
  'contact' => "/js/contact.js",
  'form' => "/js/form.js",
  'fomrcontacts' => "/js/fomrcontacts.js",
  'HOME' => "/js/pass.js",
  'ROUTE' => "/js/route.js",
  'INMOVILIZADOS' => "/js/vi.js",
  'TYRES' => "/js/tyres.js"
];

$css = (object)[
  'GALICIA' => "/css/galicia.css",
  'CHECHU' => "/css/style11.css"
];

$uri = $_SERVER['PHP_SELF'];
$page = strtoupper(substr(explode("/",$uri)[count(explode("/",$uri))-1],0,-4));
$src = ".";
!strstr("$uri",'home') == '/home.php' ? $src = ".." : '';
strpos($uri,'center') > 0 ? $src = "../.." : '';
?>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#317EFB"/>
<meta name="description" content="Agenda de contactos y claves para empleados de PPCR del call center">
<link rel="icon" href="<?php echo $src . '/img/icons8-herramientas-del-administrador-96.png'; ?>" type="image/x-icon">
<link rel="stylesheet" href="<?php echo $src; ?>/css/table.css">
<link rel="stylesheet" href="<?php echo $src . $css[$user] ?> defer >
<script type="text/javascript" src="<?php echo $src; ?>/js/script1.js" defer ></script>
<script type="text/javascript" src="<?php echo $src . $scripts->$page; ?>" defer ></script>
<title>Rascanalgas - <?php echo $page; ?></title>