<?php
include_once '../connection/data.php';

$list = 'Desconocido';
$pvp = 0;
$dto = 0;

$contacts = new Contacts();

$rows = $contacts->getRefer(str_replace(' ','',$_POST['referencia']));

if(sizeof($rows) > 0){
    $pvp = number_format($rows[0][4],2,',','.');
    $dto = $contacts->getDto($rows[0][7]);
    $dto = $dto[0]['dto'];
    $list = trim($rows[0][2],'000')."<p>
        PVP: ".$pvp."€";
}
$arr = array('descripcionPrecio' => $list, 'precio' => $pvp, 'descuento' => $dto);
echo json_encode($arr);