<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$nuevas = $contacts->getAssigCountNew($_POST['usuario'],$_POST['puesto'],$_POST['status'])[0][0];

echo $nuevas;