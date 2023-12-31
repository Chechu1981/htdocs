<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$user = $contacts->getUserBySessid($_POST['session']);

$rows = $contacts->getAssigPending($_POST['id'],$user);

function getCliente($cliente,$placa){
  $contacts = new Contacts();
  $rows = $contacts->getClientNameByPlate(explode('-',$cliente)[0],substr($placa,0,3));

  if(count($rows) > 0)
      return $rows[0][6];
  else
    return '';
}

function getDescRef($referencia){
  $descripcion = 'Desconocido';
  $contacts = new Contacts();
  $rows = $contacts->getRefer($referencia);

  if(sizeof($rows) > 0){
      foreach ($rows as $row) { 
          $descripcion = trim($rows[0][2],'000');
      }
  }

  return $descripcion;
}

function formatRef($referencia){
  $contacts = new Contacts();
  return $contacts->formatRef($referencia);
}

$dataCliente = file_get_contents("../json/cesionesCliente.json");
$codgClient = json_decode($dataCliente, true);
$data = file_get_contents("../json/cesiones.json");
$codg = json_decode($data, true);
$agent = '';
$agent_head = '';
if($_POST['id'] != 'new') {
    $agent_head = "<li>Agente</li>";
}

$imgOrigen  = "Origen<img alt='arrow' src='../img/sort_both.png' id='sortOrigen'/>";
$imgDestino = "Destino<img alt='arrow' src='../img/sort_both.png' id='sortDestino'/>";
$imgDate = "<li>Envío<img alt='arrow' src='../img/sort_both.png' id='sortEnvio'/></li>";

if($_POST['sort'] == 'origen')
    $imgOrigen = "<li>Origen<img alt='arrow' src='../img/sort_desc.png' id='sortOrigen'/></li>";
if($_POST['sort'] == 'destino')
    $imgDestino = "<li>Destino<img alt='arrow' src='../img/sort_desc.png' id='sortDestino'/></li>";

$agent = '';
$agent_head = '';

if($_POST['id'] != 'new')
  $agent_head = "<li>Agente</li>";

$lists = "<ul class='heading assignPendingAdv'>
        <li><span>".$imgOrigen."</span> > <span>".$imgDestino."</span></li>
        <li>Cliente</li>
        <li>Comentario</li>
        <li>Referencia</li>
        <li>Cantidad</li>
        <li>Pedido</li>
        <li>NFM</li>
        <li>Frágil</li>
        <li>D</li>
        <li>Tratado</li>
        <li>Eliminar</li>
        <li>Enviar</li>
        ".$agent_head."
        </ul>"; 

if(sizeof($rows) > 0){
  foreach ($rows as $row) {
    $designRefer = getDescRef($row[4]);
    $formatref = formatRef($row[4]);
    $clientName = getCliente($row[3],$row[2]);
    $important = "";
    if($_POST['id']!= 'new') 
      $agent = '<li title="Agente">'.$row[10].'</li>';
    $fecha = explode(" ", $row[8]);
    $fechaD = explode("-", $fecha[0]);
    $fechaR = explode("-", $row[9]);
    $fragChecked = "";
    $nfmChecked = "";
    $nfm = '';
    $disgon = '';
    $btnDestinoPress = '';
    $btnOrigenPress = '';
    $li = '<li class="delete" title="Marcar como cesión recibida"><img id="'.$row[0].'" alt="tick" src="../img/done_FILL0_wght400_GRAD0_opsz24.png"></li>';
    if(($_POST['id']) != 'new')
      $li = '<li title="Envío: ">'.$fechaR[2].'/'.$fechaR[1].'/'.$fechaR[0].'</li>';
    if($row[13] == 1)
      $fragChecked = 'checked="checked"';
    if($row[2] == 'VIGO' && $row[13] == 1){
      $disgon = '<input type="checkbox" ></input>';
      if($row[18] == 1)
      $disgon = '<input type="checkbox" checked="checked"></input>';
    }
    if($row[15]== 1)
      $btnOrigenPress = 'active-city-press';
    if($row[16]== 1)
      $btnDestinoPress = 'active-city-press';
    if($row[14] == 1){
      $nfm = 'NM';
      $nfmChecked = 'checked="checked"';
    }
    if($codgClient[$row[1].$row[2].$nfm] == "6254-1" ||$codgClient[$row[1].$row[2].$nfm] == "78713-1"){
      $important = 'important';
    }
    $lists .= '
    <ul class="assignPendingAdv">
      <li title="Copiar: Origen > Destino" class="">
        <span class="active-city '.$btnOrigenPress.'">'.$row[1].'</span> > <span class="active-city '.$btnDestinoPress.'">'.$row[2].'</span>
        <span class="copy '.$important.'" style="grid-column: 1 / 4;font-size: medium;">'.$codgClient[$row[1].$row[2].$nfm].'</span>
      </li>
      <li title="Destino: " style="display:none">'.$row[2].'</li>
      <li title="Cliente: " class="copy" style="font-size: medium;display:flex;flex-direction:column" value="'.$row[3].'">'.$row[3].'<span style="font-size:9px;text-align:center;line-height: 7px;">'.$clientName.'</span></li>
      <li title="Ref. Cliente: " style="display:none">'.$row[12].'</li>
      <li title="Comentario: " class="copy">'.$row[11].'</li>
      <li title="Referencia: '.$row[4].'" class="copy" style="font-size: medium;display:flex;flex-direction:column">'.$formatref.'<span style="font-size:9px;text-align:center;line-height: 7px;">'.$designRefer.'</span></li>
      <li title="Cantidad: ">'.$row[5].'</li>
      <li title="Pedido: "><input type="text" value="'.$row[7].'"></input></li>
      <li title="NFM: "><input type="checkbox" '.$nfmChecked.'></input></li>
      <li title="Frágil: "><input type="checkbox" '.$fragChecked.'></input></li>
      <li title="Disgon: ">'.$disgon.'</li>
      <li title="agente"><input type="text" value="'.$row[17].'"></li>
      <li title="Eliminar: '.$row[4].'" class="delete" id="'.$row[0].'"><img src="../img/delete_FILL0_wght400_GRAD0_opsz24.png" alt="eliminar"></li>
      <li title="enviar" class="send" id="send'.$row[0].'">📩</li>
    </ul>';
  }
}

echo $lists;