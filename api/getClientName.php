<?php
include_once '../connection/data.php';

$lists = '<h1>No se han encontrado conincidencias</h1>';
$contacts = new Contacts();

$rows = $contacts->getClientNameByPlate($_POST['search'],$_POST['placa']);

if(count($rows) > 0)
    echo $rows[0][6];
else
	echo '';