<?php
$contacts = new Contacts();
$usuario = $_COOKIE['user'];
$hash = $_COOKIE['id'];
$puesto = $_COOKIE['puesto'];
$nuevas = $contacts->getAssigCountNew($usuario,$puesto,'')[0][0];
$allAdvAssigns = $contacts->getAssigCountNew($usuario,$puesto,'all')[0][0];
$enCurso = $contacts->getAssigCountNew($usuario, $puesto,'ready')[0][0];

if($nuevas > 0)
  $nuevas = "<span class='round'>".$nuevas."</span>";
else
  $nuevas = "<span class='round'>0</span>";

if($allAdvAssigns > 0 && $allAdvAssigns < 100)
  $allAdvAssigns = "<span class='round' title=".$allAdvAssigns.">".$allAdvAssigns."</span>";
elseif($allAdvAssigns > 99)
  $allAdvAssigns = "<span class='round' title=".$allAdvAssigns.">+99</span>";
else
  $allAdvAssigns = "<span class='round'>0</span>";

$btnAll = '';

if($puesto == 'ADV'){
  $btnAll = '<button id="all">'.$allAdvAssigns.' Todas</button>';
}

if($enCurso > 0 && $enCurso < 100)
  $enCurso = "<span class='round' title=".$enCurso.">".$enCurso."</span>";
elseif($enCurso > 99)
  $enCurso = "<span class='round' title=".$enCurso.">+99</span>";
else
  $enCurso = "";

$titulo = "Cesiones de " . $usuario;
?>
<section class="subButtons">
  <button id="new"><?php echo $nuevas; ?> Nuevas Cesiones</button>
  <?=  $btnAll ?>
  <button id="find">Buscar</button>
  <button id="ready"><?php echo $enCurso; ?> En curso</button>
  <button id="finish">Rechazadas</button>
  <button id="status">Estadística</button>
</section>