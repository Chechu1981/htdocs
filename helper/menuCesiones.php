<?php
$contacts = new Contacts();
$user = $contacts->getUserBySessid($_GET['id']);
$usuario = $user[0][1];
$hash = $user[0][5];
$puesto = $user[0][4];
$nuevas = $contacts->getAssigCountNew($usuario)[0][0];
$allAdvAssigns = $contacts->getAssigCountNew('all')[0][0];
$btnAll = '';

if($nuevas > 0)
$nuevas = "<span class='round'>".$nuevas."</span>";
else
$nuevas = "";

if($allAdvAssigns > 0)
$allAdvAssigns = "<span class='round'>".$allAdvAssigns."</span>";
else
$allAdvAssigns = "";

if($puesto == 'ADV')
  $btnAll = '<button id="all">'.$allAdvAssigns.' Todas</button>';

$enCurso = $contacts->getAssigCount($usuario)[0][0];
if($enCurso > 0)
  $enCurso = "<span class='round'>".$enCurso."</span>";
else
  $enCurso = "";
?>
<h1>Cesiones</h1>
<section class="subButtons">
  <button id="new" class="active"><?php echo $nuevas; ?> Nuevas Cesiones</button>
  <?php echo $btnAll; ?>
  <button id="find">Buscar</button>
  <button id="ready"><?php echo $enCurso; ?> En curso</button>
  <button id="finish">Hechas</button>
  <button id="status">Estadística</button>
</section>