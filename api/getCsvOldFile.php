<?php

$placas = array(
  "027130L" => "PPCR BALEARES",
  "027135M" => "PPCR BARCELONA",
  "027120K" => "PPCR GRANADA",
  "027015L" => "PPCR MADRID",
  "027066M" => "PPCR PATERNA",
  "027110G" => "PPCR SEVILLA",
  "027115E" => "PPCR VIGO",
  "027125R" => "PPCR ZARAGOZA"
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

$charset = array('=', '"');

$ref = '';
if(@$_POST['referencia'] != '')
  $ref = $_POST['referencia'];

$oldFile = $contacts->getLastFile($nplacas[trim($_POST['placa'])],$ref);

$htmlList = '';
$contador = 0;
$reemp = 0;
for($i = 0;$i < sizeof($oldFile);$i++){
  $contador++;
  $alerta = "";
  $marcado = "";
  $operario = "Amuentar la prioridad";
  if($oldFile[$i]["reemplazamiento"] != ""){
    $alerta = " <span class='alertReemp' id='".$oldFile[$i]["reemplazamiento"]."'>⚠</span>";
    $reemp++;
  }
  if($oldFile[$i]["marcado"] != ""){
    $operario = $oldFile[$i]["marcado"];
    $marcado = 'class="inmovUpdate"';
  }
  $htmlList .= '<ul '.$marcado.'>
    <li id="'.$oldFile[$i]["id"].'">' . $contador . ' </li>
    <li>'.$oldFile[$i]["fecha"].'</li>
    <li>'.$oldFile[$i]["cuenta"].'</li>
    <li>'.$oldFile[$i]["nombre"].'</li>
    <li>'.$oldFile[$i]["npedido"].'<a href="#" title="'.$operario.'" class="ahover">📰</a></li>
    <li>'.$contacts->formatRef($oldFile[$i]["referencia"]).$alerta.'</li>
    <li>'.$oldFile[$i]["designacion"].'</li>
    <li>'.$oldFile[$i]["cantidad"].'</li>
    <li>'.$oldFile[$i]["prioridad"].'</li>
  </ul>';
}

$listReemp = "";
if($reemp > 0)
  $listReemp = " * ".$reemp." <span id='all' class='alertReemp'>⚠</span>";

echo "<h2>".$placas[$oldFile[0]['placa']] . " - ".$oldFile[0]["libre"]." - ".sizeof($oldFile)." lineas ".$listReemp."</h2>" . $htmlList;
