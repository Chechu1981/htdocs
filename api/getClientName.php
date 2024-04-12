<?php
include_once '../connection/data.php';

$lists = '<h1>No se han encontrado conincidencias</h1>';
$contacts = new Contacts();

$placa = $_POST['placa'];
if($_POST['placa'] == 'SAN')
    $placa = "VIG";

$rows = $contacts->getClientNameByPlate($_POST['search'],$placa);

if(count($rows) > 0)
    echo json_encode($rows);
else
	echo json_encode('{}');