<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->updateProv($_POST['id'],
$_POST['nombre'],
$_POST['direccion'], 
$_POST['email'],
$_POST['placa'],
$_POST['id_prov'], 
$_POST['marca'],
$_POST['tipo'],
$_POST['telefono'],
$_POST['entrega']);

echo 'ok';