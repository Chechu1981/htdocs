<?php
$contacts = new Contacts();
$user = $contacts->getUserBySessid($_GET['id']);
$usuario = $user[0][1];
$hash = $user[0][5];
$puesto = $user[0][4];
$nuevas = $contacts->getAssigCountNew($usuario,$puesto,'')[0][0];
$allAdvAssigns = $contacts->getAssigCountNew($usuario,$puesto,'all')[0][0];
$enCurso = $contacts->getAssigCountNew($usuario, $puesto,'ready')[0][0];

if($nuevas > 0)
  $nuevas = "<span class='round'>".$nuevas."</span>";
else
  $nuevas = "";

if($allAdvAssigns > 0)
  $allAdvAssigns = "<span class='round'>".$allAdvAssigns."</span>";
else
  $allAdvAssigns = "";

$btnAll = '';
if($puesto == 'ADV')
  $btnAll = '<button id="all">'.$allAdvAssigns.' Todas</button>';

if($enCurso > 0)
  $enCurso = "<span class='round'>".$enCurso."</span>";
else
  $enCurso = "";

$titulo = "Cesiones de " . $usuario;
?>
<section class="subButtons">
  <button id="new"><?php echo $nuevas; ?> Nuevas Cesiones</button>
  <?php echo $btnAll; ?>
  <button id="find">Buscar</button>
  <button id="ready"><?php echo $enCurso; ?> En curso</button>
  <button id="finish">Rechazadas</button>
  <button id="status">Estadística</button>
</section>