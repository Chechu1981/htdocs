<?php
include_once '../connection/data.php';

$methods = new Contacts();

$rows = $methods->getCredentialsMA($_POST['placa']);

echo json_encode($rows[0]);