<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$user = $contacts->getUserBySessid($_POST['session']);

$rows = $contacts->getAssig($_POST['id'],$user,@$_POST['sort']);

function getCliente($cliente,$placa){
  $contacts = new Contacts();
  $rows = $contacts->getClientNameByPlate(explode('-',$cliente)[0],substr($placa,0,3));

  if(count($rows) > 0)
    return $rows[0][6];
  else
    return '';
}

function formatRef($referencia){
  $contacts = new Contacts();
  return $contacts->formatRef($referencia);
}

function getDesignacion($referencia){
  $descripcion = "Desconocido";
  $contacts = new Contacts();
  $rows = $contacts->getRefer(str_replace(' ','',$referencia));

  if(count($rows) > 0)
    $descripcion = $rows[0][2];
  return $descripcion;
}

$imgOrigen  = "<li style='display:flex'>Origen<img alt='arrow' src='../../img/sort_both.png' id='sortOrigen'/></li>";
$imgDestino = "<li>Destino<img alt='arrow' src='../../img/sort_both.png' id='sortDestino'/></li>";
$imgDate = "<li>Envío<img alt='arrow' src='../../img/sort_both.png' id='sortEnvio'/></li>";

if(@$_POST['sort'] == 'origen')
    $imgOrigen = "<li style='display:flex'>Origen<img alt='arrow' src='../../img/sort_desc.png' id='sortOrigen'/></li>";
if(@$_POST['sort'] == 'destino')
    $imgDestino = "<li>Destino<img alt='arrow' src='../../img/sort_desc.png' id='sortDestino'/></li>";
if(@$_POST['sort'] == 'date')
    $imgDate = "<li>Envío<img alt='arrow' src='../../img/sort_desc.png' id='sortEnvio'/></li>";

$agent = '';
$agent_head = '';
if($_POST['id'] != 'new')
    $agent_head = "<li>Agente</li>";

$lists = "<ul class='heading'>"
        .$imgOrigen.$imgDestino."
        <li>Cliente</li>
        <li>Referencia</li>
        <li>Denominación</li>
        <li>Cantidad</li>
        <li>NFM</li>
        <li>Pedido</li>
        <li>Comentario</li>".
        $imgDate."
        <li>Recibido</li>
        ".$agent_head."
        </ul>"; 

if(sizeof($rows) > 0){
    foreach ($rows as $row) { 
      $formatref = formatRef($row[4]);
      //$clientName = getCliente($row[3],$row[2]);
      $clientName = '';
      //$designacion = getDesignacion($row[4]);
      $designacion = "";
      if($_POST['id']!= 'new') {
          $agent = '<li title="Agente">'.$row[10].'</li>';
      }
      $nfm = "";
      if($row[14])
          $nfm = "NFM";
      $fecha = explode(" ", $row[8]);
      $fechaD = explode("-", $fecha[0]);
      $fechaR = explode("-", $row[9]);
      $li = '<li class="delete" title="Marcar como cesión recibida"><img id="'.$row[0].'" alt="tick" src="../../img/done_FILL0_wght400_GRAD0_opsz24.png"></li>';
      if(($_POST['id']) != 'new')
        $li = '<li title="Envío: ">'.$fechaR[2].'/'.$fechaR[1].'/'.$fechaR[0].'</li>';
      $lists .= '
      <ul id="'.$row[0].'">
        <li title="Origen: " style="display:block">'.$row[1].'</li>
        <li title="Destino: ">'.$row[2].'</li>
        <li title="Cliente: " class="tableLegend">'.$row[3].'<legend class="legend">' .$clientName.'</legend></li>
        <li title="Referencia: '.$row[4].'" class="copy">'.$formatref.'</li>
        <li title="Denominación: ">'.$designacion.'</li>
        <li title="Cantidad: ">'.$row[5].'</li>
        <li title="NFM: ">'.$nfm.'</li>
        <li title="Pedido: ">'.$row[7].'</li>
        <li title="Comentario: ">'.$row[11].'</li>
        <li title="Envío: ">'.$fechaD[2].'/'.$fechaD[1].'/'.$fechaD[0].' '.$fecha[1].'</li>
        '.$li.$agent.'
      </ul>';
    }
}else{
  $lists = "<h2>No hay coincidencias</h2>";
}

echo $lists;