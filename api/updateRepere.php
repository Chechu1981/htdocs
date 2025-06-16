<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$status = $contacts->updateRepere($_POST['id'],$_POST['repere'],$_POST['ref']);
echo $status;

?>