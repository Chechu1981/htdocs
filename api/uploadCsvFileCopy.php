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

$nplacas = array(
  "PPCR BALEARES" => "027130L",
  "PPCR BARCELONA" => "027135M",
  "PPCR GRANADA" => "027120K",
  "PPCR MADRID" => "027015L",
  "PPCR PATERNA" => "027066M",
  "PPCR SEVILLA" => "027110G",
  "PPCR VIGO" => "027115E",
  "PPCR ZARAGOZA" => "027125R"
);

$prioridadIcar = array(
  "1" => "2",
  "2" => "3",
  "3" => "4",
  "4" => "6",
  "5" => "7",
  "" => "8"
);

include_once '../connection/data.php';
$contacts = new Contacts();

$filename=$_FILES["file"]["name"];
$info = new SplFileInfo($filename);
$extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);

$filename = $_FILES['file']['tmp_name'];
$handle = fopen($filename, "r");
$items = array();
$newSortList = array();
$charset = array('=', '"');
$placa = 'DESCONOCIDO';

/*Vuelco el fichero en una array */
while(($data = fgetcsv($handle, 1000, ";")) !== FALSE ){
  $placa = $data[13];
  if($placa != 'DO'){
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
      'fentrega' => $data[9],
      'npedido' => $data[19],
      'prioridad' => $prioridadIcar[$data[17]],
      'reemplazamiento' => $data[46],
      'marcado' => '',
      'fecha_act' => date('d-m-Y H:i:s'),
      'marca' => $data[30]]);
  }
}

$htmlList = "";

/* Compruebo que el fichero del Power se haya extraido para una placa */
$mismaPlaca = true;
for($n = 1; $n < count($items); $n++) {
  if($items[$n]['placa'] != @$items[$n+1]['placa'] && ($n+1) < count($items)){
    $mismaPlaca = false;
  }
}

/* Extraigo el fichero anterior en un array */
$oldFile = $contacts->getLastFile(trim($items[1]['placa']),'');

/* Dejo las actualizaciónes de prioridad como estaban */
for($i = 0;$i < sizeof($oldFile);$i++){
  for($n = 0; $n < count($items); $n++) {
    if($oldFile[$i]['marcado'] != '')
      if($oldFile[$i]['cuenta'] == $items[$n]['cuenta'] && $oldFile[$i]['referencia'] == $items[$n]['referencia'] && $oldFile[$i]['fecha'] == $items[$n]['fecha']){
        $items[$n]['prioridad'] = $oldFile[$i]['prioridad'];
        $items[$n]['marcado'] = $oldFile[$i]['marcado'];
      }
  }
}

if($mismaPlaca){
  $contacts->updateInmovilment($items);
}

/* Comparo el fichero de entrada con la BBDD */
for($n = 0; $n < count($items); $n++) {
  for($i = 0;$i < sizeof($oldFile);$i++){
    if($items[$n]['aviso'] == "")
      $items[$n]['aviso'] = 'encontrado';
    if($oldFile[$i]['aviso'] == $items[$n]['aviso'] && $oldFile[$i]['prioridad'] == $items[$n]['prioridad'])
      $items[$n]['aviso'] = 'encontrado';
  }
}

/* Creo nuevo array con la diferencia */
foreach($items as $key){
  if($key['aviso'] != 'encontrado'){
    array_push($newSortList,['fecha' => $key['fecha'],
    'cuenta' => $key['cuenta'],
    'nombre' => $key['nombre'],
    'referencia' => $key['referencia'],
    'designacion' => $key['designacion'],
    'fiabilidad' => $key['fiabilidad'],
    'placa' => $key['placa'],
    'aviso' => $key['aviso'],
    'vin' => $key['vin'],
    'fentrega' => $key['fentrega'],
    'cantidad' => $key['cantidad'],
    'npedido' => $key['npedido'],
    'prioridad' => $key['prioridad'],
    'reemplazamiento' => $key['reemplazamiento'],
    'marca' => $key['marca'],
    'fecha_act' => date('d-m-Y H:i:s')]);
  }
}

/* Cuento las lineas que bajan de prioridad */
$up = 0;
$down = 0;
for($n = 0; $n < count($items); $n++) {
  for($i = 0;$i < sizeof($oldFile);$i++){
    if($items[$n]['aviso'] != 'encontrado'){
      if($items[$n]['aviso'] == $oldFile[$i]['aviso']){
        if($items[$n]['prioridad'] > $oldFile[$i]['prioridad']){
          $down++;
        }
      }
    }
  }
}

/* Actualizo la BBDD y agrego el formato a la variable de impresión */
if($mismaPlaca){
  $contacts->updateSortInmov($newSortList,trim($items[1]['placa']));
  sleep(3);
  $newShortFile = $contacts->getLastShortFile(trim($items[1]['placa']));
  $contador = 0;
  for($index = 0;$index < sizeof($newShortFile);$index++){
    $contador++;
    $alerta = "";
    $marcado = "";
    if($newShortFile[$index]["reemplazamiento"] != "")
      $alerta = " <span class='alertReemp' id='".$newShortFile[$index]["reemplazamiento"]."'>⚠</span>";
    if($oldFile[$i]["marcado"] != "")
      $marcado = 'class="inmovUpdate"';
    $htmlList .= '
    <ul '.$marcado.'>
      <li>' . $contador . ' </li>
      <li>' . $newShortFile[$index]["fecha"] . '</li>
      <li>' . $newShortFile[$index]["cuenta"] . '</li>
      <li>' . $newShortFile[$index]["nombre"] . '</li>
      <li title="'.$newShortFile[$index]["marca"].'">' . $newShortFile[$index]["npedido"] . '</li>
      <li class="copy" title="' . $newShortFile[$index]["referencia"] . '" id="'.$newShortFile[$index]["id"].'">' . $contacts->formatRef($newShortFile[$index]["referencia"]) . $alerta . '</li>
      <li>' . $newShortFile[$index]["designacion"] . '</li>
      <li>' . $newShortFile[$index]["cantidad"] . '</li>
      <li class="priority">' . $newShortFile[$index]["prioridad"] . '</li>
    </ul>';
  }
  
  /* Resto las lineas que bajan de prioridad a las totales a priorizar y inerto en BBDD */
  $up = sizeof($newShortFile) - $down;
  $contacts->newFileInmv($up, $down, $placa);
  
  /* Imprimo la cabecera y las lista */ 
  echo "<h2>".$placas[$items[1]['placa']] ." - ".$oldFile[0]["libre"].' - '.sizeof($newSortList) ." lineas</h2>" .$htmlList;
}else{
  echo "<h2>Las referencias del fichero no corresponden a la misma placa</h2>";
}