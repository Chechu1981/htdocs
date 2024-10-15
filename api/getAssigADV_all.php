<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$user = $contacts->getUserBySessid($_POST['session']);

$rows = $contacts->getAssigPending('new','all');

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

$lists = "<h1>No hay Cesiones</h1>";

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

function createOptionsOrigin($id,$placa){
  $placas = array('MADRID','SANTIAGO','BARCELONA','ZARAGOZA','VALENCIA','GRANADA','SEVILLA','PALMA','MISTER-AUTO');
  $select = '<select name="origen" id="origen'.$id.'">';
  foreach ($placas as $key) {
    $nombre = $key;
    if($key == 'MISTER-AUTO')
      $key = 'MAT';
    if($key == $placa)
      $select .= '<option value="'.$key.'" selected>'.$nombre.'</option>';
    else
      $select .= '<option value="'.$key.'">'.$nombre.'</option>';
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
            <li>Agente</li>
            <li>Eliminar</li>
            <li>Enviar</li>
            ".$agent_head."
            <li>usuario</li>
            <li></li>
            <li></li>
          </ul>"; 
  $contador = 1;
  foreach ($rows as $row) {
    $designRefer = $row[19];
    $formatref = formatRef($row[4]);
    $clientName = $row[20];
    $agente = $row[17];
    $usuario = $row[10];
    $puesto = $row[21];
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
    $envioDisgon = '';
    $btnDestinoPress = '';
    $btnOrigenPress = '';
    $rechazado = '❌';
    $li = '<li class="delete" title="Marcar como cesión recibida"><img id="'.$row[0].'" alt="tick" src="../img/done_FILL0_wght400_GRAD0_opsz24.png"></li>';
    if(($_POST['id']) != 'new')
      $li = '<li title="Envío: ">'.$fechaR[2].'/'.$fechaR[1].'/'.$fechaR[0].'</li>';
    if($row[13] == 1)
      $fragChecked = 'checked="checked"';
    if($row[13] == 1){
      $disgon = '<input type="checkbox" ></input>';
      if($row[18] == 1){
        $disgon = '<input type="checkbox" checked="checked"></input>';
        $envioDisgon = '📦';
        if($row[1] == 'SANTIAGO')
          $envioDisgon = '🚚';
        if($row[22] == 1){
          $envioDisgon = "✅";
        }
      }
    }
    $libre = '';
    if($agente == '')
      $libre = 'libre';
    if($row[23] == 1){
      $rechazado = "🚫";
    }
    if($row[15]== 1)
      $btnOrigenPress = 'ledOn';
    if($row[16]== 1)
      $btnDestinoPress = 'active-city-press';
    if($row[14] == 1){
      $nfm = 'NM';
      $nfmChecked = 'checked="checked"';
    }
    
    $rutasDirectas = ["6251-2","78709-1","12752-1","105252-1","105342-1","14075-1","7545-1","78766-1"];
    $rutasPreguntar = ["6254-1","78713-1"];
    $rutasPortes = ["12874","14079-1","14101-1","6280-1","14086-1","105247-1","105511-1","105400-1","78665-1","78713-1","105311-1"];
    
    if($row[1] != 'MAT' && $row[1] != 'EXT'){
      if(in_array($codgClient[$row[1].$row[2].$nfm],$rutasPreguntar))
        $important = 'important';
      if(in_array($codgClient[$row[1].$row[2].$nfm],$rutasDirectas))
        $important = 'route';
      $numPie = $codgClient[$row[1].$row[2].$nfm];
    }
    if($row[1] == 'MAT'){
      $numPie = $row[12];
    }
    /*if($row[2] == 'SANTIAGO')
      $important = 'important';*/
    $origen = $row[1];
    if($user[0][4] == 'ADV')
      $origen = createOptionsOrigin($row[0],$row[1]);
    $destino = $row[2];
    if($row[2] == 'SANTIAGO')
      $destino = "SANTIAGO";
    $opctions = createOptons($agente);
    $fechaS = explode("-", $row[25]);
    $fechaSHora = explode(".",explode(" ", $row[25])[1]);
    $lists .= '
    <ul class="assignPendingAdv '.$libre.'" title="'.$contador++.'">
      <li title="Copiar: Origen > Destino" class="">
        <span class="ledOff '.$btnOrigenPress.'"></span>'.$origen.'
        <span class="active-city '.$btnDestinoPress.'">'.$destino.'</span>
        <span class="copy '.$important.'" style="grid-column: 1 / 4;font-size: medium;">'.$numPie.'</span>
      </li>
      <li title="Destino: " style="display:none">'.$destino.'</li>
      <li title="Cliente: " class="copy" style="font-size: medium;display:flex;flex-direction:column" value="'.$row[3].'">'.$row[3].'<span style="font-size:9px;text-align:center;line-height: 7px;">'.$clientName.'</span></li>
      <li title="Ref. Cliente: " style="display:none">'.$row[12].'</li>
      <li title="Copiar comentario" class="copy"><textarea type="text" name="Comentario" id="coment'.$row[0].'">'.$row[11].'</textarea></li>
      <li title="Referencia: '.$row[4].'" class="copy" style="font-size: medium;display:flex;flex-direction:column">'.$formatref.'<span style="font-size:9px;text-align:center;line-height: 7px;">'.$designRefer.'</span></li>
      <li title="Cantidad: " class="storage">'.$row[5].'</li>
      <li title="Pedido: "><input type="text" value="'.$row[7].'" name="pedido"></input></li>
      <li title="NFM: "><input type="checkbox" '.$nfmChecked.' name="nfm"></input></li>
      <li title="Frágil: "><input type="checkbox" '.$fragChecked.' name="fragil"></input></li>
      <li title="Disgon: ">'.$disgon.'</li>
      <li title="agente">
        <select name="agente" id="agente'.$row[0].'">
        '.$opctions.'
        </select>
      </li>
      <li title="Eliminar: '.$row[4].'" class="delete" id="'.$row[0].'"><img src="../img/delete_FILL0_wght400_GRAD0_opsz24.png" alt="eliminar"></li>
      <li class="send" ><span title="Enviar Cesión" id="send'.$row[0].'">📩</span><span title="Enviar Disgon" id="disgon'.$row[0].'">'.$envioDisgon.'</span></li>
      <li title="'.explode(" ",$fechaS[2])[0]."/".$fechaS[1]."/".$fechaS[0]." ".$fechaSHora[0].'">'.$usuario.'<br>('.$puesto.')</li>
      <li class="send"><span id="rechazo'.$row[0].'" title="'.$row[24].'">'.$rechazado.'</span></li>
    </ul>';
  }
}

echo $lists;