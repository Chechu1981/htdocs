<?php
include_once '../connection/data.php';

$lists = '';
$contacts = new Contacts();

$rows = $contacts->deleteAssigADV($_POST['id'],$_POST['puesto']);

echo $rows;