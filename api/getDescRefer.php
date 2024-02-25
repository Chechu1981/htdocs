<?php
include_once '../connection/data.php';

$list = 'Desconocido';
$contacts = new Contacts();

$rows = $contacts->getRefer(str_replace(' ','',$_POST['referencia']));

if(sizeof($rows) > 0){
    $list = '';
    $list .= trim($rows[0][2],'000')."<p>
        PVP: ".number_format($rows[0][4],2,',','.')."€";
}

echo $list;