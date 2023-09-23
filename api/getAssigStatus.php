<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$users = $contacts->getAllUsers();

$allData = array();

foreach ($users as $user){ 
  $rows = $contacts->assigStatus($user[1]);  

  $date = array();
  $num = array();

  foreach($rows as $row){
    array_push($date,$row[0]);
    array_push($num,$row[1]);
  }
  array_push($allData,array($user[1],$date,$num));
  
}

$rows = $contacts->assigStatus('%%');  

$date = array();
$num = array();

  foreach($rows as $row){
    array_push($date,$row[0]);
    array_push($num,$row[1]);
  }
array_push($allData,array('TODAS',$date,$num));
echo json_encode($allData);
