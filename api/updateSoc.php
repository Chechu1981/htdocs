<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$items = [
    $_POST['id'],
    $_POST['ncuenta'],
    $_POST['cuenta'],
    $_POST['nombre'],
    $_POST['cif'],
    $_POST['cp'],
    $_POST['ciudad'],
    $_POST['nplaca'],
    $_POST['placa']];

$rows = $contacts->updateSoc($items);
echo $rows;