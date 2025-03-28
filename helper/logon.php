<?php
include_once $src . '/connection/data.php';
$user;

function getUser($user, $pass){
  $contacts = new Contacts();
  $charsetExtract = array("'");

  $username = str_replace($charsetExtract, "",@$user);
  $userpsw = str_replace($charsetExtract, "",@$pass);

  $rows = $contacts->getUser($username,$userpsw);
  return count($rows) === 1 ? $rows[0] : "false";
}

if(!isset($_COOKIE['user']) && isset($_POST['usr']) && isset($_POST['psw'])){
  $user = getUser(@$_POST['usr'], @$_POST['psw']);
  if($user != "false"){
    setcookie('user', $user[1]);
    setcookie('puesto', $user[4]);
    setcookie('id', $user[5]);	
  }else{
    header('Location: ../../../index.php');
  }
}else if($_COOKIE['user'] == ''){
  header('Location: ../../../index.php');
}


?>