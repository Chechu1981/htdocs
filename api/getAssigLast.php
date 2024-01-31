<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->getAssigLast();

if(count($rows)>0)
  echo json_encode($rows[0]);
else 
  echo json_encode("{}");