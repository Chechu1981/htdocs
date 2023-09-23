<?php

include_once '../connection/data.php';
$contacts = new Contacts();

$filename = $_FILES["file"]["name"];
$info = new SplFileInfo($filename);
$extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);
$charset = array('=', '"',"'");

$filename = $_FILES['file']['tmp_name'];
$handle = fopen($filename, "r");
$tarifa = array();

while(($data = fgetcsv($handle, 0,";",'"',"~")) !== FALSE ){
  if($data[8] != 'REFERENCIA' && $data[0] != ''){
    array_push($tarifa,[
        'proveedor' => $data[0],
        'ctipo' => $data[12],
        'referencia' => $data[8],
        'denominacion' => utf8_encode(str_replace($charset,'',$data[9])),
        'designacion' => utf8_encode(str_replace($charset,'',$data[70])),
        'pvp' => floatval(str_replace(",",".",$data[16])),
        'uv' => intval($data[20]),
        'peso' => intval($data[21]),
        'dto' => $data[22],
        'refprov' => utf8_encode($data[30]),
        'pvpprov' => utf8_encode($data[31])]);
    }
  }

$query = $contacts->updatePrices($tarifa);

echo $query;