<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->getNotes();

echo $rows[0][1];