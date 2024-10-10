<?php
include_once '../connection/data.php';

$lists = '';
$contacts = new Contacts();

$rows = $contacts->deletePass($_POST['idItem']);

echo $rows;