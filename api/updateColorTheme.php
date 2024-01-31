<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->updateColorTheme($_POST['nameTheme']);
