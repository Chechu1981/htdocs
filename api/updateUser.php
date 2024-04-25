<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->updateUser($_POST['id'],$_POST['nombre'], $_POST['pass'], $_POST['puesto'], $_POST['email']);

echo 'ok';