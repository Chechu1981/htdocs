<?php include('../../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php 
  include_once('../../helper/head.php'); 
  $contacts = new Contacts();
  $hash = $contacts->getUserBySessid($_GET['id'])[0][5];
  $usuario = $contacts->getUserBySessid($_GET['id'])[0][1];
  $nuevas = $contacts->getAssigCountNew($usuario)[0][0];
  $allAssigns = "<span class='round'>" . $contacts->getAssigCountNew('all')[0][0] . "</span>";
  if($nuevas > 0)
    $nuevas = "<span class='round'>".$nuevas."</span>";
  else
    $nuevas = "";

  $enCurso = $contacts->getAssigCount($usuario)[0][0];
  if($enCurso > 0)
    $enCurso = "<span class='round'>".$enCurso."</span>";
  else
    $enCurso = "";
  ?>
</head>
<body>
  <div id="menu">
    <?php include_once '../../helper/menu.php'; ?>
  </div>
  <div class="search-table">
    <div id="contacts" class="contacts">
      <h1>Cesiones en curso</h1>
      <section class="subButtons">
        <button id="new"><?php echo $nuevas; ?> Nuevas Cesiones</button>
        <button id="all"><?php echo $allAssigns; ?> Todas</button>
        <button id="find">Buscar</button>
        <button id="ready" class="active"><?php echo $enCurso; ?> En curso</button>
        <button id="finish">Hechas</button>
        <button id="status">Estadística</button>
      </section>
    </div>
    <div id="cesiones"></div>
  </div>
  <?php include('./../../helper/footer.php'); ?>
</body>
</html>