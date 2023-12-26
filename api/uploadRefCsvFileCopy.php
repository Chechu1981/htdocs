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
$listFilter = array();
$charset = array('=', '"');
$placa = 'DESCONOCIDO';

/*Vuelco el fichero en una array */
$contador = 0;
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
      'marca' => $data[30],
      'comentario' => $data[21],
      'id' => $contador++,
      'sap' => $data[14]]);
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

// Guarda el fichero completo sin filtrar
if($mismaPlaca){
  $contacts->updateInmovilmentRef($items);
}

$palabrasClave = $contacts->getPalabrasClave();

// Filtra los comentarios relevantes
$contador = 0;
for($n = 0; $n < count($items); $n++) {
  $contador++;
  for($f = 0; $f < count($palabrasClave); $f++) {
    //echo $contador .': '.strtoupper($items[$n]['comentario']).' -> '. strtoupper($palabrasClave[$f][1]) . ' = ' . strpos(strtoupper($items[$n]['comentario']), strtoupper($palabrasClave[$f][1])) .'<p>';
    if(str_contains(strtoupper($items[$n]['comentario']), strtoupper($palabrasClave[$f][1])) && $palabrasClave[$f][1] != ''){
      $repetido = false;
      foreach($newSortList as $short){
        if($short['id'] == $items[$n]['id']){
          $repetido = true;
        }
      }
      if(!$repetido){
        array_push($newSortList, $items[$n]);
        array_push($listFilter, $items[$n]);
      }
    }
  }
}


// Compara los comentarios de la lista anterior con la nueva lista
$oldFile = $contacts->getLastShortRefFile($items[1]['placa']);
if(count($oldFile) > 0){
  for($j = 0;$j < count($newSortList);$j++){
    $sapNew = $newSortList[$j]['sap'];
    $refNew = $newSortList[$j]['referencia'];
    $cuentaNew = $newSortList[$j]['cuenta'];
    $comentarioNew = $newSortList[$j]['comentario'];
    for($i = 0; $i < count($oldFile);$i++){
      $sapOld = $oldFile[$i]['sap'];
      $refOld = $oldFile[$i]['referencia'];
      $cuentaOld = $oldFile[$i]['cuenta'];
      $comentarioOld = $oldFile[$i]['comentario'];
      /* añade solo si cambia el comentario o es una fila nueva */
      if($cuentaNew == $cuentaOld && $refNew == $refOld && $sapNew == $sapOld && $comentarioNew == $comentarioOld)
        unset($listFilter[$j]);
    }
  }
}

/* Guarda el fichero filtrado en la base de datos */
$contacts->updateShortRef($newSortList, $placa);

// Guarda el fichero acotado, filtrado y lo estrae de la BBDD
$contacts->updateFilterList($listFilter, $placa);
$newBDDupdateFile = $contacts->getFilterList($placa);

// Muestra el fichero acotado
if(count($newBDDupdateFile) > 0){
  $contador = 0;
  for($index = 0;$index < sizeof($newBDDupdateFile);$index++){
    $contador++;
    $alerta = "";
    $marcado = "";
    if($newBDDupdateFile[$index]["reemplazamiento"] != "")
      $alerta = " <span class='alertReemp' id='".$newBDDupdateFile[$index]["reemplazamiento"]."'>⚠</span>";
    $htmlList .= '
    <ul '.$marcado.'>
      <li>' . $contador . ' </li>
      <li>' . $newBDDupdateFile[$index]["fecha"] . '</li>
      <li title="'.$newBDDupdateFile[$index]["nombre"].'" class="info">' . $newBDDupdateFile[$index]["cuenta"] . '</li>
      <li title="'.$newBDDupdateFile[$index]["marca"].'">' . $newBDDupdateFile[$index]["npedido"] . '</li>
      <li class="copy" title="' . $newBDDupdateFile[$index]["designacion"] . '" id="'.$newBDDupdateFile[$index]["id"].'">' . $contacts->formatRef($newBDDupdateFile[$index]["referencia"]) . $alerta . '<span id="showFilterAll" class="alertReemp">🔻</span></li>
      <li>' . $newBDDupdateFile[$index]["comentario"] . '</li>
    </ul>';
  }
}

if($mismaPlaca){
  $contacts->updateInmovilmentRef($items);
}

  /* Imprimo la cabecera y las lista */ 
if($mismaPlaca){
  echo "<h2>".$placas[$items[1]['placa']] ." - ".sizeof($newBDDupdateFile) ." lineas</h2>" .$htmlList;
}else{
  echo "<h2>Las referencias del fichero no corresponden a la misma placa</h2>";
}