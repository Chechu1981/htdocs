<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->addNewProv($_POST['nombre'], $_POST['direccion'], $_POST['nprov'], $_POST['email']);

echo 'ok';