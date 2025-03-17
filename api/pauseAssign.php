<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->updatePauseAssign($_POST['id']);