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
$usuario;
$privilegio = 0;
function getUser($user, $pass){
  $charsetExtract = array("'");

  $username = str_replace($charsetExtract, "",@$user);
  $userpsw = str_replace($charsetExtract, "",@$pass);

  $rows = $GLOBALS['contacts']->getUser($username, base64_encode($userpsw));
  return count($rows) === 1 ? $rows[0] : "false";
}

if(!isset($_COOKIE['user']) && isset($_POST['usr']) && isset($_POST['psw'])){
  $usuario = getUser(@$_POST['usr'], @$_POST['psw']);
  if($usuario != "false"){
    setcookie('user', $usuario[1]);
    setcookie('puesto', $usuario[4]);
    setcookie('id', $usuario[5]);
    $privilegio = $usuario[7];
  }else{
    header('Location: ../../../index.php?error=1');
  }
}else if($_COOKIE['user'] == ''){
  header('Location: ../../../index.php?error=1');
}


?>