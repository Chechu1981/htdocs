<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$items = [
    $_POST['placa'],
    $_POST['ncliente'],
    $_POST['cif'],
    $_POST['rrdi'],
    $_POST['nombre']
];

$rows = $contacts->newSoc($items);
echo $rows;