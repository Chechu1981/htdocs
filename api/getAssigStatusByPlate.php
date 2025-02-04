<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$allData = array();

$rows = $contacts->assignStatusByPlate();  

array_push($allData,$rows);
echo json_encode($allData);
