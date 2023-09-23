<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$status = $contacts->updatePriorityInmov($_POST['id'],$_POST['priority'],$_POST['name']);
echo $status;

?>