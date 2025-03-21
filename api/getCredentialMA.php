<?php
include_once '../connection/data.php';

$methods = new Contacts();

$placa = $_POST['placa'];

if($_POST['placa'] == 'SANTIAGO') 
  $placa = 'GALICIA';

$rows = $methods->getCredentialsMA($placa);
$user = base64_decode($rows[0][4]);
$pass = base64_decode($rows[0][5]);

echo json_encode([$user, $pass]);