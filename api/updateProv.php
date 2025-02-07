<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->updateProv($_POST['id'],$_POST['nombre'], $_POST['direccion'], $_POST['nprov'], $_POST['email']);

echo 'ok';