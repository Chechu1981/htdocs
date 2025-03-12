<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->getAssigStatusByPlateDestination($_POST['dateIn'], $_POST['dateOut']);  

echo json_encode($rows);