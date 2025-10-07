<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$idSesion = $_POST['session'];
$userFilds = $contacts->getUserBySessid($idSesion);
$user = $userFilds[0][1];
$puesto = $userFilds[0][4];
$tratado = "";
$contacts = new Contacts();

if($puesto == 'ADV')
    $tratado = strtoupper($user);

function getCliente($cliente,$placa){
    if($placa == 'SANTIAGO')
        $placa = "VIGO";
    IF($placa == 'MÁLAGA')
        $placa = "GRANADA";
    $rows = $GLOBALS['contacts']->getClientNameByPlate(explode('-',$cliente)[0],substr($placa,0,3));
    if(count($rows) > 0)
        return $rows[0][6];
    else
        return '';
}

function getDescRef($referencia){
    global $contacts;
    $rowsRefer = $contacts->getRefer(str_replace(' ','',$referencia));
    $descripcion = 'Desconocido';
    if(sizeof($rowsRefer) > 0){
        foreach ($rowsRefer as $row) { 
            $descripcion = trim($row[2],'000') . " (" . str_replace('.',',',$row[4])."€)";
        }
    }
    return $descripcion;
}

function getPvp($referencia){
    $pvp = 0;
    global $contacts;
    $rows = $contacts->getRefer(str_replace(' ','',$referencia));
    if(sizeof($rows) > 0){
        foreach ($rows as $row) { 
            $pvp = $row[4];
        }
    }
    return $pvp;
}

$nombreCliente = getCliente($_POST['cliente'],$_POST['destino']);
$designacion = getDescRef($_POST['ref']);
$comentario = str_replace("'","\"",$_POST['comentario']);
$rows = '';
/* NO SE PUEDEN HACER CESIONES DE BATERÍAS, NI LUBRICANTE EUROREPAR

$stringAlert = ['E:BATERÍA','E:BATERIA','E:LUBRICANTE'];
$num = 0;
foreach($stringAlert as $str){
    $encontrado = str_contains($designacion,$str);
    if($encontrado > 0)
        $num++;
}

CESIONES DE GRANADA INHABILITADAS

if($_POST['origen'] == 'GRANADA' || $_POST['destino'] == 'GRANADA'){
    $rows = "ErrorOrigen";
}

/* Busca si hay portes de las cesiones de Zaragoza por Disgon. Emplea mucho tiempo en hacer tres consultas a servidor 
$pvp = getPvp($_POST['ref']);
if($_POST['destino'] == 'ZARAGOZA' && @$_POST['disgon'] == true){
    $portes = round($pvp / 100);
    $comentario .= ` ¡¡OJO!! $portes de portes`;
}
*/
$items = [
    $_POST['origen'],
    $_POST['destino'],
    $_POST['cliente'],
    $_POST['refClient'],
    $comentario,
    $_POST['ref'],
    $_POST['pvp'],
    $_POST['cantidad'],
    $_POST['frag'],
    $_POST['nfm'],
    $user,
    $_POST['pedido'],
    @$_POST['disgon'],
    $designacion,
    $nombreCliente,
    $tratado,
    $puesto,
    @$_POST['correo']
];
if($rows != 'ErrorOrigen' && $idSesion != "undefined"){
    $rows = $contacts->newAssigADV2023($items);
    echo $rows;
}else{
    if($idSesion == "undefined")
        header('location: ../index.php');
}