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

$oldFile = $contacts->getLastShortFile($nplacas[trim($_POST['placa'])]);
$dateOld = $contacts->getLastFile($nplacas[trim($_POST['placa'])],'');

$htmlList = '';
$contador = 0;
for($i = 0;$i < sizeof($oldFile);$i++){
  $contador++;
  $marcado = '';
  if($oldFile[$i]['marcado'] == 'SI')
    $marcado = "check";
  $alerta = "";
  if($oldFile[$i]["reemplazamiento"] != "")
    $alerta = " <span class='alertReemp' id='".$oldFile[$i]["reemplazamiento"]."'>⚠</span>";
  $htmlList .= '<ul>
    <li>' . $contador . ' </li>
    <li>'.$oldFile[$i]["fecha"].'</li>
    <li>'.$oldFile[$i]["cuenta"].'</li>
    <li>'.$oldFile[$i]["nombre"].'</li>
    <li title="'.$oldFile[$i]["marca"].'">'.$oldFile[$i]["npedido"].'</li>
    <li class="copy '.$marcado.'" title="'.$oldFile[$i]["referencia"].'" id="'.$oldFile[$i]['id'].'">'.$contacts->formatRef($oldFile[$i]["referencia"]).$alerta.'</li>
    <li>'.$oldFile[$i]["designacion"].'</li>
    <li>'.$oldFile[$i]["cantidad"].'</li>
    <li title="history" class="history">'.$oldFile[$i]["prioridad"].'</li>
  </ul>';
}

$cabecera = "<h2>".$_POST['placa'] . " - ".$dateOld[0]["libre"]." - ".sizeof($oldFile)." lineas</h2>";

if(sizeof($oldFile) == 0)
  $cabecera .= "<h3>No hay referencias que priorizar.</h3>";

echo $cabecera . $htmlList;