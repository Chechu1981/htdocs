<?php
$src = ".";
$uri = $_SERVER['PHP_SELF'];
!strstr("$uri",'home') == '/home.php' ? $src = ".." : '';
strpos($uri,'center') > 0 ? $src = "../.." : '';
strpos($uri,'buscar') > 0 ? $src = "../.." : '';
strpos($uri,'extbrand') > 0 ? $src = "../.." : '';
strpos($uri,'ready') > 0 ? $src = "../.." : '';
strpos($uri,'finish') > 0 ? $src = "../.." : '';
strpos($uri,'status') > 0 ? $src = "../.." : '';
strpos($uri,'test') > 0 ? $src = ".." : '';
!strstr("$uri",'home') == '/home.php' || strpos($uri,'test') > 0 ? $src = ".." : '.';
strpos($uri,'center') > 0 ? $src = "../.." : '.';
strpos($uri,'assigns') > 0 ? $src = "../.." : '.';

include_once $src . '/connection/data.php';
$contacts = new Contacts();
$usuario = [];
$privilegio = 0;

if(!isset($_COOKIE['user']) && isset($_POST['usr']) && isset($_POST['psw'])){
  $usuario = $GLOBALS['contacts']->getUser($_POST['usr'], base64_encode($_POST['psw']));
}else if(isset($_COOKIE['id'])){
  $usuario = $GLOBALS['contacts']->getUserByHash($_COOKIE['id']);
}

if(!isset($_COOKIE['id']) && count($usuario) === 1){
  setcookie('user', $usuario[0][1]);
  setcookie('puesto', $usuario[0][4]);
  setcookie('id', $usuario[0][5]);
  $privilegio = $usuario[0][7];
}else if($_COOKIE['id'] != $usuario[0][5]){
  header('Location: ../../../index.php?error=1');  
}

?>