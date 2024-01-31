<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->addNewUser($_POST['nombre'], $_POST['pass'], $_POST['puesto']);

echo 'ok';