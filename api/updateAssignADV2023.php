<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$update = True;
$esTratado = $contacts->esTratado($_POST['id']);
if($esTratado[0]['tratado'] != '' && $_POST['puesto'] != 'ADV')
    $update = False;  
if(@$_POST['origen'] == '')
    $update = False;
if($update){
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
    str_replace("'","\"",@$_POST['comentario']));
}else{
    $rows = $contacts->updateComentAssigADV2023(
    $_POST['id'],
    str_replace("'","\"",$_POST['comentario']),
  );
}