<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->addNewUser($_POST['nombre'], $_POST['priv'], $_POST['puesto'], $_POST['email']);

echo 'ok';