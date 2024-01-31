<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$nuevas = $contacts->getAssigCountNew($_POST['usuario'])[0][0];

echo $nuevas;