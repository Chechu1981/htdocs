<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->getMailProv($_POST['proveedor']);

echo json_encode($rows[0]);