<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->getAssigStatusTratados($_POST['dateIn'], $_POST['dateOut']);

if(count($rows)>0)
  echo json_encode($rows);
else 
  echo json_encode("{}");