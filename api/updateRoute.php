<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$status = $contacts->updateRoute($_POST['id'],$_POST['corte'],$_POST['salida']);
echo $status;