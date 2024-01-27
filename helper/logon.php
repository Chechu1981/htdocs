<?php
$uri = $_SERVER['PHP_SELF'];

$src = ".";
!strstr("$uri",'home') == '/home.php' ? $src = ".." : '';
strpos($uri,'center') > 0 ? $src = "../.." : '';
strpos($uri,'buscar') > 0 ? $src = "../.." : '';
strpos($uri,'ready') > 0 ? $src = "../.." : '';
strpos($uri,'finish') > 0 ? $src = "../.." : '';
strpos($uri,'status') > 0 ? $src = "../.." : '';
strpos($uri,'test') > 0 ? $src = ".." : '';

include_once($src.'/helper/head.php'); 
$contacts = new Contacts();

if($_GET['id'] == '')
  header('Location: ../../../index.html');

$userBdd = $contacts->getUserBySessid($_GET['id']);

$usrOk = false;

for($i = 0; $i < count($userBdd); $i++){
    if($userBdd[0][5] == $_GET['id'])
      $usrOk = true;
}

if(!$usrOk)
  header('Location: ../../../index.html');

?>