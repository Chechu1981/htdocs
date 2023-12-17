<?php
$src = ".";
!strstr("$uri",'home') == '/home.php' ? $src = ".." : '.';
strpos($uri,'center') > 0 ? $src = "../.." : '.';
strpos($uri,'assigns') > 0 ? $src = "../.." : '.';

include_once $src . '/connection/data.php';
$contacts = new Contacts();

$scripts = (object)[
  'CENTRAL' => "/js/center3.js",
  'MADRID' => "/js/center3.js",
  'BARCELONA' => "/js/center3.js",
  'PATERNA' => "/js/center3.js",
  'SEVILLA' => "/js/center3.js",
  'GRANADA' => "/js/center3.js",
  'PALMA' => "/js/center3.js",
  'ZARAGOZA' => "/js/center3.js",
  'VIGO' => "/js/center3.js",
  'CENTROS' => "/js/center3.js",
  'CESIONES1' => "/js/cesiones202312.js?1234",
  'CESIONES' => "/js/cesiones19.js",
  'CESIONESTEST' => "/js/cesionestest.js",
  'CESIONESADV' => "/js/cesionesADV.js?130",
  'BUSCAR' => "/../js/buscarCesiones.js?101",
  'READY' => "/../js/readyCesiones.js?101",
  'STATUS' => "/../js/statusCesiones.js?101",
  'FINISH' => "/../js/finishCesiones.js?102",
  'CESIONESADV_TEST' => "/js/cesionesADV_test.js?125",
  'LIBRETA' => "/js/libreta13.js",
  'contact' => "/js/contact2.js",
  'form' => "/js/form1.js",
  'fomrcontacts' => "/js/fomrcontacts1.js",
  'HOME' => "/js/pass7.js",
  'ROUTE' => "/js/route.js",
  'ROUTETEST' => "/js/routeTest.js",
  'INMOVILIZADOS' => "/js/vi18.js?1237",
  'INMSTATUS' => "/js/inmStat.js",
  'CONFIGROUTES' => "/js/cfgRutas2.js",
  'CONFIGREPERE' => "/js/formRepere.js",
  'CONFIGSOC' => "/js/cfgSoc.js",
  'UPDATEPRICE' => "/js/updatePrice.js",
  'CESIONESENVIO' => "/js/cesionesEnvio.js",
  'TYRES' => "/js/tyres.js",
  'TEST' => "/js/test.js",
  'TXTTOXLS' => "/js/txtToXls.js",
  'CONFIGCLIENT' => "/js/updateClient.js",
  'CONFIGPENDING' => "/js/updatePending.js?112"
];

$usr = $contacts->getAllUsers();

$css = array();
foreach($usr as $userTheme){
  $css[strtoupper($userTheme['nombre'])] = "/css/".strtolower($userTheme['nombre']).".css";
}

$uri = $_SERVER['PHP_SELF'];
$page = strtoupper(substr(explode("/",$uri)[count(explode("/",$uri))-1],0,-4));

$user = $contacts->getUserBySessid($_GET['id']);

?>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#317EFB"/>
<meta name="description" content="Agenda de contactos y claves para empleados de PPCR del call center">
<link rel="icon" href="<?php echo $src . '/img/icons8-herramientas-del-administrador-96.png'; ?>" type="image/x-icon">
<link rel="stylesheet" href="<?php echo $src; ?>/css/style28.css?1240" defer content="1">
<link rel="stylesheet" href="<?php echo $src; ?>/css/150027.css" defer content="1">
<link rel="stylesheet" href="<?php echo $src . $css[$user]; ?>" defer content="0">
<script type="text/javascript" src="<?php echo $src; ?>/js/script20.js" defer content='no-cache'></script>
<script type="text/javascript" src="<?php echo $src . $scripts->$page; ?>" defer content="0"></script>
<title>Chechu - <?php echo $page; ?></title>