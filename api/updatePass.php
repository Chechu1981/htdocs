<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$items = [
    $_POST['id'],
    $_POST['marca'],
    $_POST['placa'],
    $_POST['cuenta'],
    $_POST['usr'],
    $_POST['pswd'],
    $_POST['web'],
    $_POST['phone'],
    $_POST['tipo']
];

$rows = $contacts->updatePass($items);
echo $rows;