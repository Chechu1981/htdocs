<?php
$uri = $_SERVER['PHP_SELF'];
$src = ".";
!strstr("$uri",'home') == '/home.php' ? $src = ".." : '';
strpos($uri,'center') > 0 ? $src = "../.." : '';
$data = file_get_contents($src.'/json/sesiones.json');
$usr = json_decode($data, true);

$usrOk = false;

for($i = 0; $i < sizeof($usr); $i++){
    if($usr[$i]['hash'] == $_GET['id'])
      $usrOk = true;
}

if(!$usrOk)
  header('Location: ../../../index.html');

?>