<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->updateAssigDeclane($_POST['id']);
