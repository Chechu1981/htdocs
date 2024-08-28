<?php
include_once '../connection/data.php';
$contacts = new Contacts();

if(@$_POST['origen'] != ''){
  $rows = $contacts->updateAssigADV2023(
    $_POST['id'],
    $_POST['fragil'],
    $_POST['envio'],
    $_POST['nfm'],
    $_POST['pedido'],
    $_POST['tratado'],
    $_POST['origenBtn'],
    $_POST['destinoBtn'],
    $_POST['origen'],
    @$_POST['disgon'],
    @$_POST['comentario']);
  echo $rows;
}else{
  $rows = $contacts->updateComentAssigADV2023(
    $_POST['id'],
    $_POST['comentario'],
  );
}