<?php

include_once '../connection/data.php';
$contacts = new Contacts();

$filename = $_FILES["file"]["name"];
$info = new SplFileInfo($filename);
$extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);
$charset = array('=', '"');

ini_set('memory_limit','256M');
ini_set('max_execution_time', 300);
$filename = $_FILES['file']['tmp_name'];
$handle = fopen($filename, "r");
$madrid = array();


$nplaca = [
  "DO"=>"",
  "027130L"=>"PPCR BALEARES",
  "027135M"=>"PPCR BARCELONA",
  "027120K"=>"PPCR GRANADA",
  "027015L"=>"PPCR MADRID",
  "027066M"=>"PPCR PATERNA",
  "027110G"=>"PPCR SEVILLA",
  "027115E"=>"PPCR VIGO",
  "027125R"=>"PPCR ZARAGOZA"
];

while(($data = fgetcsv($handle, 0,";")) !== FALSE ){
  array_push($madrid,['fecha' => $data[0],
    'cuenta' => str_replace($charset,'',$data[1]),
    'nombre' => $data[3],
    'referencia' => str_replace($charset,'',$data[6]),
    'designacion' => $data[7],
    'fiabilidad' => $data[11],
    'placa' => $data[13],
    'aviso' => $data[16],
    'vin' => $data[34],
    'cantidad' => $data[8],
    'npedido' => $data[19],
    'fentrega' => $data[9],
    'comentario' => $data[5],
    'cesion' => $data[22]]);
}

$query = $contacts->updatePending($madrid);

//file_put_contents("../json/allPending.json", json_encode($madrid));

echo $query;