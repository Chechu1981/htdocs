<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->updateAssigADVall(
  $_POST['id'],
  $_POST['fragil'],
  $_POST['envio'],
  $_POST['nfm'],
  $_POST['pedido'],
  $_POST['tratado'],
  $_POST['origenBtn'],
  $_POST['destinoBtn'],
  $_POST['origen'],
  @$_POST['disgon']);
echo $rows;