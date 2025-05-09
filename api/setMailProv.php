<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$usr = $contacts->setMailProv($_POST['idLine']);