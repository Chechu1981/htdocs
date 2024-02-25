<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$user = $contacts->getUserBySessid($_POST['session']);
$puesto = $user[0][4];

$rows = $contacts->getAssigPending($_POST['id'],$user[0][1]);

$allUsers = $contacts->getAllUsers();

function formatRef($referencia){
  $contacts = new Contacts();
  return $contacts->formatRef(trim($referencia," "));
}

$dataCliente = file_get_contents("../json/cesionesCliente.json");
$codgClient = json_decode($dataCliente, true);
$data = file_get_contents("../json/cesiones.json");
$codg = json_decode($data, true);
$agent = '';
$agent_head = '';
$liEnviar = '';
if($_POST['id'] != 'new') {
    $agent_head = "<li>Agente</li>";
}
if($puesto == 'ADV'){
  $liEnviar = "<li>Enviar</li>";
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

function createOptons($user){
  $optionsList = '<option value="" selected ></option>';
  global $allUsers;
  for($i = 0; $i < count($allUsers); $i++){
    if($allUsers[$i][4] != 'ADV')
    continue;
    if($user == strtoupper($allUsers[$i][1]))
      $optionsList .= '<option value="'.strtoupper($allUsers[$i][1]).'" selected >'.strtoupper($allUsers[$i][1]).'</option>';
    else
      $optionsList .= '<option value="'.strtoupper($allUsers[$i][1]).'">'.strtoupper($allUsers[$i][1]).'</option>';
  }
  return $optionsList;
}

if($_POST['id'] != 'new')
  $agent_head = "<li>Agente</li>";

$lists = "<h1>No hay cesiones</h1>";

function createOptions($id,$placa){
  $placas = array('MADRID','VIGO','BARCELONA','ZARAGOZA','VALENCIA','GRANADA','SEVILLA','PALMA');
  $select = '<select name="origen" id="origen'.$id.'">';
  foreach ($placas as $key) {
    if($key == $placa)
      $select .= '<option value="'.$key.'" selected>'.$key.'</option>';
    else
      $select .= '<option value="'.$key.'">'.$key.'</option>';
  }
  $select .= '</select>';
  return $select;
}

if(sizeof($rows) > 0){
  $lists = "<ul class='heading assignPendingAdv'>
            <li><span>".$imgOrigen."</span><span>".$imgDestino."</span></li>
            <li>Cliente</li>
            <li>Comentario</li>
            <li>Referencia</li>
            <li>Cantidad</li>
            <li>Pedido</li>
            <li>NFM</li>
            <li>Frágil</li>
            <li>D</li>
            <li>Tratado</li>
            <li>Eliminar</li>"
            .$liEnviar
            .$agent_head."
            <li></li>
          </ul>";
  $contador = 1;
  foreach ($rows as $row) {
    $designRefer = $row[19];
    $agente = $row[17];
    $formatref = formatRef($row[4]);
    $clientName = $row[20];
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
    $envioDisgon = '';
    $btnEnviar = '';
    $rechazado = '';
    $rechazadoStyle = '';
    $usuarioCesion = '';
    $options = createOptons($agente);
    $li = '<li class="delete" title="Marcar como cesión recibida"><img id="'.$row[0].'" alt="tick" src="../img/done_FILL0_wght400_GRAD0_opsz24.png"></li>';
    if($puesto == 'ADV'){
      $btnEnviar = '<span title="Enviar Cesión" id="send'.$row[0].'">📩</span>';
    }
    if(($_POST['id']) != 'new')
      $li = '<li title="Envío: ">'.$fechaR[2].'/'.$fechaR[1].'/'.$fechaR[0].'</li>';
    if($row[13] == 1)
      $fragChecked = 'checked="checked"';
    if($row[13] == 1){
      $disgon = '<input type="checkbox" ></input>';
      if($row[18] == 1)
        $disgon = '<input type="checkbox" checked="checked"></input>';
      if($row[18] == 1 && $puesto == 'ADV'){
        $envioDisgon = '🚚';
        if($row[22] == 1)
          $envioDisgon = "✅";
      }
    }
    $origen = '<span id="origen'.$row[0].'">'.$row[1].'</span>';
    if($puesto == 'ADV')
      $origen = createOptions($row[0],$row[1]);
    if($row[10] != $user[0][1])
      $usuarioCesion = $row[10].'<span id="rechazo'.$row[0].'">❌</span>';
    if($row[23] == 1){
      $rechazado = "🚫";
      $rechazadoStyle = 'background-color:#ff000073';
    }
    if($row[15]== 1)
      $btnOrigenPress = 'ledOn';
    if($row[16]== 1)
      $btnDestinoPress = 'active-city-press';
    if($row[14] == 1){
      $nfm = 'NM';
      $nfmChecked = 'checked="checked"';
    }
    if($codgClient[$row[1].$row[2].$nfm] == "6254-1" ||$codgClient[$row[1].$row[2].$nfm] == "78713-1"){
      $important = 'important';
    }
    /*if($row[2] == 'VIGO')
      $important = 'important';*/
    
    $lists .= '
    <ul class="assignPendingAdv" title="'.$contador++.'" style="'.$rechazadoStyle.'">
      <li title="Copiar: Origen > Destino" class="">
        <span class="ledOff '.$btnOrigenPress.'"></span>'.$origen.'
        <span id="destinoBtn'.$row[0].'" class="active-city '.$btnDestinoPress.'">'.$row[2].'</span>
        <span class="copy '.$important.'" style="grid-column: 1 / 4;font-size: medium;">'.$codgClient[$row[1].$row[2].$nfm].'</span>
      </li>
      <li title="Destino: " style="display:none">'.$row[2].'</li>
      <li title="Cliente: " class="copy" style="font-size: medium;display:flex;flex-direction:column" value="'.$row[3].'">'.$row[3].'<span style="font-size:9px;text-align:center;line-height: 7px;">'.$clientName.'</span></li>
      <li title="Ref. Cliente: " style="display:none">'.$row[12].'</li>
      <li title="Comentario: " class="copy">'.$row[11].'</li>
      <li title="Referencia: '.$row[4].'" class="copy" style="font-size: medium;display:flex;flex-direction:column">'.$formatref.'<span style="font-size:9px;text-align:center;line-height: 7px;">'.$designRefer.'</span></li>
      <li title="Cantidad: " class="storage">'.$row[5].'</li>
      <li title="Pedido: "><input type="text" value="'.$row[7].'" name="pedido"></input></li>
      <li title="NFM: "><input type="checkbox" '.$nfmChecked.' name="nfm"></input></li>
      <li title="Frágil: "><input type="checkbox" '.$fragChecked.' name="fragil"></input></li>
      <li title="Disgon: ">'.$disgon.'</li>
      <li title="agente">
        <select name="agente" id="agente'.$row[0].'">
        '.$options.'
        </select>
      </li>
      <li title="Eliminar: '.$row[4].'" class="delete" id="'.$row[0].'"><img src="../img/delete_FILL0_wght400_GRAD0_opsz24.png" alt="eliminar"><span title="'.$row[24].'">'.$rechazado.'</span></li>
      <li class="send" >'.$btnEnviar.'<span title="Enviar Disgon" id="disgon'.$row[0].'">'.$envioDisgon.'</span></li>
      <li class="send" style="font-size:small">'.$usuarioCesion.'</li>
    </ul>';
  }
}

echo $lists;