<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$userFilds = $contacts->getUserBySessid($_POST['session']);
$user = $userFilds[0][1];
$puesto = $userFilds[0][4];
$tratado = "";
$contacts = new Contacts();

if($puesto == 'ADV')
    $tratado = strtoupper($user);

function getCliente($cliente,$placa){
    if($placa == 'SANTIAGO')
        $placa = "VIGO";    $rows = $GLOBALS['contacts']->getClientNameByPlate(explode('-',$cliente)[0],substr($placa,0,3));
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
$stringAlert = ['E:BATERÍA','E:BATERIA','E:LUBRICANTE'];
$num = '';
$rows = '';
foreach($stringAlert as $str){
    $num = strpos($designacion,$str);
    if($num > false)
        break;
}
if($num != '' && $_POST['origen'] == 'GRANADA' && $puesto != 'ADV'){
    $rows = "Error";
}
$comentario = str_replace("'","\"",$_POST['comentario']);

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
    $puesto
];
if($rows != 'Error')
    $rows = $contacts->newAssigADV2023($items);
echo $rows;