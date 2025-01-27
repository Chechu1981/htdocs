<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$rows = $contacts->getClientById($_POST['id']);

if(count($rows) > 0)
    echo json_encode($rows);
else
	echo json_encode('{}');