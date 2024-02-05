<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$status = $contacts->updateRechazo($_POST['id'],$_POST['switch'],$_POST['texto']);
