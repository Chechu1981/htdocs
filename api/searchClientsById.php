<?php
include_once '../connection/data.php';

$lists = '<h1>No se han encontrado conincidencias</h1>';
$contacts = new Contacts();

$rows = $contacts->getRoutesHTMLId($_POST['id']);

echo json_encode($rows);