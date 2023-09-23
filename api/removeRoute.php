<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$status = $contacts->removeRoute($_POST['id']);
echo $status;