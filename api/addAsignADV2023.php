<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$userFilds = $contacts->getUserBySessid($_POST['session']);
$user = $userFilds[0][1];
$puesto = $userFilds[0][4];
$tratado = "";
if($puesto == 'ADV')
    $tratado = strtoupper($user);

function getCliente($cliente,$placa){
    if($placa == 'SANTIAGO')
        $placa = "VIGO";
    $contacts = new Contacts();
    $rows = $contacts->getClientNameByPlate(explode('-',$cliente)[0],substr($placa,0,3));

    if(count($rows) > 0)
        return $rows[0][6];
    else
        return '';
}
  
function getDescRef($referencia){
    $descripcion = 'Desconocido';
    $contacts = new Contacts();
    $rows = $contacts->getRefer(str_replace(' ','',$referencia));

    if(sizeof($rows) > 0){
        foreach ($rows as $row) { 
            $descripcion = trim($rows[0][2],'000') . " (" . str_replace('.',',',$rows[0][4])."€)";
        }
    }

    return $descripcion;
}

$NombreCliente = getCliente($_POST['cliente'],$_POST['destino']);
$Designacion = getDescRef($_POST['ref']);

$items = [
    $_POST['origen'],
    $_POST['destino'],
    $_POST['cliente'],
    $_POST['refClient'],
    $_POST['comentario'],
    $_POST['ref'],
    $_POST['pvp'],
    $_POST['cantidad'],
    $_POST['frag'],
    $_POST['nfm'],
    $user,
    $_POST['pedido'],
    @$_POST['disgon'],
    $Designacion,
    $NombreCliente,
    $tratado,
    $puesto
];

$rows = $contacts->newAssigADV2023($items);
echo $rows;