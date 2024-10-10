<?php
$src = ".";
!strstr("$uri",'home') == '/home.php' || strpos($uri,'test') > 0 ? $src = ".." : '.';
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
  'CENTROS' => "/js/center3.js?102",
  'CESIONES1' => "/js/cesiones202312.js?1235",
  'CESIONES' => "/js/cesiones19.js",
  'CESIONESALL' => "/js/cesionesAll.js?197",
  'CESIONESADV' => "/js/cesionesADV.js?202",
  'BUSCAR' => "/../js/buscarCesiones.js?105",
  'READY' => "/../js/readyCesiones.js?105",
  'STATUS' => "/../js/statusCesiones.js?105",
  'FINISH' => "/../js/finishCesiones.js?108",
  'CESIONESADV_TEST' => "/js/cesionesADV_test.js?129",
  'LIBRETA' => "/js/libreta.js?102",
  'contact' => "/js/contact2.js",
  'form' => "/js/form1.js",
  'fomrcontacts' => "/js/fomrcontacts1.js",
  'HOME' => "/js/pass7.js?101",
  'ROUTE' => "/js/route.js",
  'ROUTETEST' => "/js/routeTest.js?103",
  'INMOVILIZADOS' => "/js/vi18.js?1237",
  'REFERENCIADOS' => "/js/referenciados.js?1002",
  'INMSTATUS' => "/js/inmStat.js?104",
  'CONFIGROUTES' => "/js/cfgRutas2.js",
  'CONFIGREPERE' => "/js/formRepere.js",
  'CONFIGSOC' => "/js/cfgSoc.js",
  'UPDATEPRICE' => "/js/updatePrice.js",
  'CESIONESENVIO' => "/js/cesionesEnvio.js",
  'TYRES' => "/js/tyres.js",
  'INDEX' => "/js/test.js",
  'TXTTOXLS' => "/js/txtToXls.js",
  'CONFIGCLIENT' => "/js/updateClient.js",
  'CONFIGPENDING' => "/js/updatePending.js?112",
  'ACEITE' => "/js/aceite.js?114",
  'BATERIAS' => "/js/baterias.js?118",
  'CONFIGUSERS' => "/js/users.js?102",
  'FORMNEWUSER' => "/../js/formNewUser.js?102",
  'FORMEDITUSER' => "/../js/formNewUser.js?102"
];

$usr = $contacts->getAllUsers();

$uri = $_SERVER['PHP_SELF'];
$page = strtoupper(substr(explode("/",$uri)[count(explode("/",$uri))-1],0,-4));

$userBdd = $contacts->getUserBySessid($_GET['id'] ?? 0);
$user = strtoupper($userBdd[0][3]);

?>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#317EFB"/>
<meta name="description" content="Agenda de contactos y claves para empleados de PPCR del call center">
<link rel="icon" href="<?= $src . '/img/icons8-coche-64.png'; ?>" type="image/x-icon">
<link rel="stylesheet" href="<?= $src; ?>/css/style28.css?1288" defer content="1">
<link rel="stylesheet" href="<?= $src; ?>/css/150027.css?1006" defer content="1">
<link rel="stylesheet" href="<?= "$src/css/" . str_replace(" ","_",strtolower($user)).".css?" . rand(1,500); ?>" defer content="0">
<script type="text/javascript" src="<?= $src; ?>/js/script20.js?1022" defer content='no-cache'></script>
<script type="module" src="<?= $src . $scripts->$page; ?>" defer content="0"></script>
<title>Chechu - <?= $page; ?></title>