<?php
include_once '../connection/data.php';

$lists = 'Desconocido';
$contacts = new Contacts();

$rows = $contacts->getRefer(str_replace("'","",$_POST['search']));

if(count($rows) > 0){
  $dto = $contacts->getDto($rows[0][7]);
  $rows[0]['dtoNum'] = $dto[0][1];
  echo json_encode($rows[0]);
}else{
  echo json_encode("{}");
}