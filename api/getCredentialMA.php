<?php
include_once '../connection/data.php';

$methods = new Contacts();

$placa = $_POST['placa'];

if($_POST['placa'] == 'SANTIAGO') 
  $placa = 'GALICIA';

$rows = $methods->getCredentialsMA($placa);

echo json_encode($rows[0]);