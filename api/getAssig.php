<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$user = $contacts->getUserBySessid($_POST['session']);

$puesto = $user[0][4];
$usuario = $user[0][1];
$origen = @$_POST['origen'];
$destino = @$_POST['destino'];
$asegurado = @$_POST['asegurado'];

if($puesto == 'ADV' || $puesto == 'DESBORDE')
  $puesto = $user[0][1];

$rows = $contacts->getAssig(str_replace(' ','',ltrim($_POST['id'],'0')),$usuario,$puesto,@$origen, @$destino, @$asegurado);

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
  return $contacts->formatRef(trim($referencia," "));
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

/*if(@$_POST['sort'] == 'origen')
    $imgOrigen = "<li style='display:flex'>Origen<img alt='arrow' src='../../img/sort_desc.png' id='sortOrigen'/></li>";
if(@$_POST['sort'] == 'destino')
    $imgDestino = "<li>Destino<img alt='arrow' src='../../img/sort_desc.png' id='sortDestino'/></li>";
if(@$_POST['sort'] == 'date')
    $imgDate = "<li>Envío<img alt='arrow' src='../../img/sort_desc.png' id='sortEnvio'/></li>";
*/
$agent = '';

$lists = "<ul class='heading'>
        $imgOrigen $imgDestino
        <li>Cliente</li>
        <li>Referencia</li>
        <li>Denominación</li>
        <li>Cantidad</li>
        <li>NFM</li>
        <li>Pedido</li>
        <li>Comentario</li>
        $imgDate
        <li>Recibido</li>
        <li>Tratado</li>
        <li>Agente</li>
        </ul>"; 

if(sizeof($rows) > 0){
    foreach ($rows as $row) { 
      $formatref = formatRef($row[4]);
      //$clientName = getCliente($row[3],$row[2]);
      $clientName = $row[20];
      //$designacion = getDesignacion($row[4]);
      $designacion = $row[19];
      if($_POST['id'] != 'new')
        $agent = "<li title='Agente'>$row[10]</li>";
      $rechazado = '';
      if($row[23] == 1)
        $rechazado = "<span id='rechazo$row[0]' title='$row[24]' style='cursor:pointer'>🚫</span>";
      if($row[1] == 'MAT')
        $row[1] = "MR AUTO<br /><legend class='legend copy'>$row[12]</legend>";
      if($row[1] == 'EXT')
        $row[1] = "C.EXTERNA<br /><legend class='legend'>$row[12]</legend>";
      $nfm = "";
      if($row[14])
          $nfm = "NFM";
      $fecha = explode(" ", $row[8]);
      $fechaD = explode("-", $fecha[0]);
      $fechaR = explode("-", $row[9]);
      $fechaS = explode("-", $row[25]);
      $fechaSHora = explode(".",explode(" ", $row[25])[1]);
      $cadenaFechaEntrada = "";
      $disgon = "";
      if($row[18] == 2)
        $disgon = "<em style='background-color:green;color:white'>(LOGISTICA) </em>";
      if($row[18] == 1)
        $disgon = "<em style='background-color:green;color:white'>(DISGON) </em>";
      if($row[25] > '2024-04-11 00:00:00.000000')
        $cadenaFechaEntrada = explode(" ",$fechaS[2])[0] . "/$fechaS[1]/$fechaS[0] $fechaSHora[0]";
      $li = "<li class='delete' title='Marcar como cesión recibida'><img id='$row[0]' alt='tick' src='../../img/done_FILL0_wght400_GRAD0_opsz24.png'></li>";
      if($fechaD[0] == '0000')
        $li='<li></li>';
      if($fechaR[0] != '0000')
        $li = "<li title='Envío: '>$fechaR[2]/$fechaR[1]/$fechaR[0]</li>";
      $lists .= "
      <ul id='$row[0]'>
        <li title='Origen: ' style='display:block'>$row[1]</li>
        <li title='Destino: '>$row[2]</li>
        <li title='Cliente: ' class='tableLegend'>$row[3]<legend class='legend'>$clientName</legend></li>
        <li class='copy'>$formatref<span class='toolTip'></span></li>
        <li title='Denominación: '>$designacion</li>
        <li title='Cantidad: '>$row[5]</li>
        <li title='NFM: '>$nfm</li>
        <li title='Pedido: '>$row[7]</li>
        <li title='Comentario: ' style='display:block'>$disgon $row[11]</li>
        <li title='Envío: '>$fechaD[2]/$fechaD[1]/$fechaD[0] $fecha[1]</li>
        $li
        <li title='Tratado'>$row[17]</li>
        <li title='$row[21]' style='flex-wrap:wrap'>$row[10]$rechazado <br>
          <span style='font-size:8px;text-align:center'>$cadenaFechaEntrada</span>
        </li>
      </ul>";
    }
}else{
  $lists = "<h2>No hay coincidencias</h2>";
}

echo $lists;