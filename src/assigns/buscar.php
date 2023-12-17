<?php include('../../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php 
  include_once('../../helper/head.php'); 
  $contacts = new Contacts();
  $nuevas = $contacts->getAssigCountNew($contacts->getUserBySessid($_GET['id']))[0][0];
  if($nuevas > 0)
    $nuevas = "<span class='round'>".$nuevas."</span>";
  else
    $nuevas = "";

  $enCurso = $contacts->getAssigCount($contacts->getUserBySessid($_GET['id']))[0][0];
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
      <h1>Buscar cesiones</h1>
      <section class="subButtons">
        <button id="new"><?php echo $nuevas; ?> Nuevas Cesiones</button>
        <button id="find" class="active">Buscar</button>
        <button id="ready"><?php echo $enCurso; ?> En curso</button>
        <button id="finish">Hechas</button>
        <button id="status">Estadística</button>
      </section>
    </div>
    <div id="search-line" class="nPass search-line search-focused">
        <span class="lupa">
          <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
          </svg>
        </span>
        <div class="textbox" id="search-box">
          <form id="search-ref">
            <input type="search" id="refAssig" placeholder="Buscar referencia">
          </form>
        </div>
      </div>
    <div id="cesiones"></div>
  </div>
  <?php include('./../../helper/footer.php'); ?>
</body>
</html>