<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->updateAssigADV(
  $_POST['id'], 
  $_POST['value'], 
  $_POST['pedido'],
  $_POST['envio'],
  $_POST['pvp']);
echo $rows;