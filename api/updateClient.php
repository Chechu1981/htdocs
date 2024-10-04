<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

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
$items = array();
$placa = $_FILES["file"]["name"];

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


try {
  if($extension == 'csv'){
    while(($data = fgetcsv($handle, 0,";")) !== FALSE ){
      /* Elimino la cabecera */
      if(!str_contains($data[0],'Ultima Factura (Emp)')){
        $envio = $data[2];
        if($data[2] == '')
          $envio = 0;
      array_push($items,[
        'placa' => str_replace('.csv','',$placa),
        'cuenta' => utf8_encode(str_replace($charset,'',$data[1])),
        'envio' => $envio,
        'telefono' => utf8_encode(str_replace($charset,'',$data[3])),
        'cliente' => utf8_encode(str_replace($charset,'',$data[4])),
        'direccion' => utf8_encode(str_replace($charset,'',$data[5])),
        'denvio' => utf8_encode(str_replace($charset,'',$data[6])),
        'poblacion' => utf8_encode(str_replace($charset,'',$data[7])),
        'provincia' => utf8_encode(str_replace($charset,'',$data[8])),
        'cp' => $data[9],
        'turnoU' => utf8_encode(str_replace($charset,'',$data[10])),
        'turnoN' => utf8_encode(str_replace($charset,'',$data[11])),
        'tipo' => utf8_encode(str_replace($charset,'',$data[12])),
        'comercial' => $data[13],
        'email' => $data[14],
        'cif' => $data[15]]);
      }
    }
    
    $query = $contacts->updateClientRoute($items);
  
    //file_put_contents("../json/allPending.json", json_encode($madrid));
  
    echo $query;
  }else{
    echo "No es un fichero CSV";
  }
} catch (\Throwable $th) {
  echo $th;
}