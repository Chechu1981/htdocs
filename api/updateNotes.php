<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->saveNotes(str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />",$_POST['txt']),1);

echo $rows;