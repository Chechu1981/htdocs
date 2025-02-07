<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$rows = $contacts->getProvExt();

echo json_encode($rows);