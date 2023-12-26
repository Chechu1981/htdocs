<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$reg = $contacts->updateShortRefFile($_POST['id']);

