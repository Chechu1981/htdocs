<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->updateAssig($_POST['id']);
echo $rows;