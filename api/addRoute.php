<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$status = $contacts->addNewRoute($_POST['centro'],$_POST['nombre'],$_POST['cutt'],$_POST['salida']);
echo $status;