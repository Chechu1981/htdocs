<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->getPauseAssign($_POST['id']);

echo json_encode($rows[0]);