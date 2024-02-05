<?php
include_once '../connection/data.php';

$lists = '<h1>No se han encontrado conincidencias</h1>';
$contacts = new Contacts();

$rows = $contacts->getClientNameByPlate($_POST['search'],$_POST['placa']);

if(count($rows) > 0)
    echo json_encode($rows);
else
	echo json_encode('{}');