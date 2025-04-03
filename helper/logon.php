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
$user;

function getUser($user, $pass){
  $contacts = new Contacts();
  $charsetExtract = array("'");

  $username = str_replace($charsetExtract, "",@$user);
  $userpsw = str_replace($charsetExtract, "",@$pass);

  $rows = $contacts->getUser($username, base64_encode($userpsw));
  return count($rows) === 1 ? $rows[0] : "false";
}

if(!isset($_COOKIE['user']) && isset($_POST['usr']) && isset($_POST['psw'])){
  $user = getUser(@$_POST['usr'], @$_POST['psw']);
  if($user != "false"){
    setcookie('user', $user[1]);
    setcookie('puesto', $user[4]);
    setcookie('id', $user[5]);
  }else{
    header('Location: ../../../index.php?error=1');
  }
}else if($_COOKIE['user'] == ''){
  header('Location: ../../../index.php?error=1');
}


?>