<?php
include_once '../connection/data.php';

$conexion = new Contacts;

$filas = $conexion->is_send($_POST['id']);
$isSend = 'ok';
if(sizeof($filas)>0){
  if($filas[0]['envio'] == "0000-00-00 00:00:00")
    $isSend = false;
}

echo $isSend;