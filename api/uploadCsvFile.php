<?php
$placas = array(
  "027130L" => "PPCR BALEARES",
  "027135M" => "PPCR BARCELONA",
  "027120K" => "PPCR GRANADA",
  "027015L" => "PPCR MADRID",
  "027066M" => "PPCR PATERNA",
  "027110G" => "PPCR SEVILLA",
  "027115E" => "PPCR VIGO",
  "027125R" => "PPCR ZARAGOZA",
);

$prioridadIcar = array(
  "1" => "2",
  "2" => "3",
  "3" => "4",
  "4" => "6",
  "5" => "7",
  "" => "8"
);

include_once '../connection/connection.php';

$filename=$_FILES["file"]["name"];
$info = new SplFileInfo($filename);
$extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);

$filename = $_FILES['file']['tmp_name'];
$handle = fopen($filename, "r");
$items = array();
$charset = array('=', '"');
$placa = 'DESCONOCIDO';

while( ($data = fgetcsv($handle, 1000, ";") ) !== FALSE ){
  $placa = $data[13];
  array_push($items,['fecha' => $data[0],
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
    'prioridad' => $data[17],
    'marca' => $data[30]]);
}

$oldFile = json_decode(file_get_contents("../json/".$placa.".json"));
file_put_contents("../json/".$placa.".json", json_encode($items));

for($i = 1; $i < count($oldFile); $i++) {
  for($n = 0; $n < count($items); $n++) {
    $items[0]['placa'] = $items[1]['placa'];
    $items[0]['fecha'] = date("d/m/y H:i:s");
    if($oldFile[$i]->aviso == $items[$n]['aviso'] && $oldFile[$i]->prioridad == $items[$n]['prioridad']){
      $items[$n]['aviso'] = '';
    }
  }
}

$newVi = array();
$htmlList = "";
foreach($items as $item) {
  if($item['aviso'] != ''){
    array_push($newVi,$item);
    if($item['designacion'] != 'Designacion'){
      $htmlList .= "<ul>
        <li>" . $item['fecha'] . "</li>
        <li>" . $item['cuenta'] . "</li>
        <li>" . $item['nombre'] . "</li>
        <li>" . $item['npedido'] . "</li>
        <li class='copy' title='copiar'>" . $item['referencia'] . "</li>
        <li>" . $item['designacion'] . "</li>
        <li>" . $item['cantidad'] . "</li>
        <li class='priority'>" . $prioridadIcar[$item['prioridad']] . "</li>
      </ul>";
    }
  }
}

ksort($newVi,1);

file_put_contents("../json/".$placa."last.json", json_encode($newVi));

//echo json_encode($newVi);

$textoInmovilizados = "";

if(sizeof($newVi) - 1 == 0){
  $textoInmovilizados = "<h3>No hay nuevas priorizaciones</h3>";
}

echo "<h2>".$placas[$items[1]['placa']] ." - ".sizeof($newVi) - 1 ." lineas</h2>". $textoInmovilizados . $htmlList;