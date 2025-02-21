<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$allData = array();

$rows = $contacts->getAssigStatusByPlateDestination($_POST['dateIn'], $_POST['dateOut']);  

array_push($allData,$rows);
echo json_encode($allData);
