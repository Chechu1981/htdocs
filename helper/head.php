<?php
$contacts = new Contacts();

$scripts = (object)[
  'CENTRAL' => "/js/center3.js?100",
  'MADRID' => "/js/center3.js?100",
  'BARCELONA' => "/js/center3.js?100",
  'PATERNA' => "/js/center3.js?100",
  'SEVILLA' => "/js/center3.js?100",
  'GRANADA' => "/js/center3.js?102",
  'PALMA' => "/js/center3.js?100",
  'ZARAGOZA' => "/js/center3.js?101",
  'VIGO' => "/js/center3.js?100",
  'CENTROS' => "/js/center3.js?108",
  'CESIONES1' => "/js/cesiones202312.js?1235",
  'EXTBRAND' => "/../js/extBrand.js?101",
  'CESIONESALL' => "/js/cesionesAll.js?211",
  'CESIONESADV' => "/js/cesiones.js?104",
  'BUSCAR' => "/../js/buscarCesiones.js?113",
  'READY' => "/../js/readyCesiones.js?110",
  'STATUS' => "/../js/statusCesiones.js?107",
  'FINISH' => "/../js/finishCesiones.js?109",
  'CESIONESADV_TEST' => "/js/cesionesADV_test.js?129",
  'LIBRETA' => "/js/libreta.js?102",
  'contact' => "/js/contact2.js",
  'form' => "/js/form1.js",
  'fomrcontacts' => "/js/fomrcontacts1.js?100",
  'HOME' => "/js/pass7.js?102",
  'ROUTE' => "/js/route.js",
  'ROUTETEST' => "/js/routeTest.js?104",
  'INMOVILIZADOS' => "/js/vi18.js?1237",
  'REFERENCIADOS' => "/js/referenciados.js?1002",
  'INMSTATUS' => "/js/inmStat.js?107",
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
  'CONFIGPROV' => "/js/prov.js?100",
  'FORMNEWPROV' => "/../js/formNewProv.js?103",
  'FORMEDITPROV' => "/../js/formNewProv.js?102",
  'FORMNEWUSER' => "/../js/formNewUser.js?103",
  'FORMEDITUSER' => "/../js/formNewUser.js?103",
  'EDITREPERE' => "/../js/formEditRepere.js?100"
];

$usr = $contacts->getAllUsers();

$uri = $_SERVER['PHP_SELF'];
$page = strtoupper(substr(explode("/",$uri)[count(explode("/",$uri))-1],0,-4));
$user = isset($_COOKIE['user']) ? $_COOKIE['user'] : $usuario[0][1];
$puesto = isset($_COOKIE['puesto']) ? $_COOKIE['puesto'] : $usuario[0][4];
$id = isset($_COOKIE['id']) ? $_COOKIE['id'] : $usuario[0][5];
$style = file_exists("$src/css/" . str_replace(" ","_",strtolower($user)).".css") ? "$src/css/" . str_replace(" ","_",strtolower($user)).".css?" . rand(1,500) : "$src/css/blue.css?" . rand(1,500);
?>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#317EFB"/>
<meta name="description" content="Agenda de contactos y claves para empleados de PPCR del call center">
<link rel="icon" href="<?= $src . '/img/icons8-coche-64.png'; ?>" type="image/x-icon">
<link rel="stylesheet" href="<?= $src; ?>/css/style28.css?1318" defer content="1">
<link rel="stylesheet" href="<?= $src; ?>/css/150027.css?1011" defer content="1">
<link rel="stylesheet" href="<?= $style ?>" defer content="0">
<script type="text/javascript" src="<?= $src; ?>/js/script20.js?1041" defer content='no-cache'></script>
<script type="module" src="<?= $src . $scripts->$page; ?>" defer content="no-cache"></script>
<title>Chechu - <?= $page; ?></title>