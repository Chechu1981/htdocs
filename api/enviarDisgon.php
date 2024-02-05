<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$status = $contacts->enviarDisgon($_POST['id']);
