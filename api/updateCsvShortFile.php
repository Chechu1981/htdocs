<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$reg = $contacts->updateShortFile($_POST['id']);

