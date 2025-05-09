<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$user = $contacts->getUserBySessid($_COOKIE['id']);
$puesto = $user[0][4];

$rows = $contacts->getAssigPending($_POST['id'],$user[0][1]);
$proveedores = $contacts->getProvExt();
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

function createOptons($user,$id){
  global $puesto;
  $disabled = '';
  if($user != '')
    $disabled = 'disabled';
  if($puesto == 'ADV')
    $disabled = ''; 
  $optionsList = '<select name="agente" id="agente'.$id.'" '.$disabled.'><option value="" selected></option>';
  global $allUsers;
  for($i = 0; $i < count($allUsers); $i++){
    if($allUsers[$i][4] != 'ADV')
      continue;
    if($user == strtoupper($allUsers[$i][1]))
      $optionsList .= '<option value="'.strtoupper($allUsers[$i][1]).'" selected >'.strtoupper($allUsers[$i][1]).'</option>';
    else
      $optionsList .= '<option value="'.strtoupper($allUsers[$i][1]).'">'.strtoupper($allUsers[$i][1]).'</option>';
  }
  $optionsList .= '<option value="ADV">ADV</option></select>';
  return $optionsList;
}

if($_POST['id'] != 'new')
  $agent_head = "<li>Agente</li>";

$lists = "<h1>No hay cesiones</h1>";

function createOptions($id,$placa,$proveedor){
  $placas = array('MADRID','SANTIAGO','BARCELONA','ZARAGOZA','VALENCIA','GRANADA','SEVILLA','PALMA','MISTER-AUTO','C. EXTERNA');
  $select = '<select name="origen" id="origen'.$id.'">';
  foreach ($placas as $key) {
    $nombre = $key;
    if($key == 'MISTER-AUTO')
      $key = 'MAT';
    if($key == 'C. EXTERNA')
      $key = 'EXT';
    if($key == $placa)
      $select .= '<option value="'.$key.'" selected>'.$nombre.'</option>';
    else
      $select .= '<option value="'.$key.'">'.$nombre.'</option>';
  }
  $select .= '</select>';
  return $select;
}

function createOptionProvExt($id,$select){
  global $proveedores;
  $optionsList = '<select name="proveedor" id="proveedorExterno'.$id.'" style="width: 100%">';
  $mail = '';
  foreach ($proveedores as $key) {
    if($key['nombre'] == $select){
      $optionsList.= '<option value="'.$key['nombre'].'" selected>'.$key['nombre'].'</option>';
      $mail = $key['mail'];
    }
    else
      $optionsList.= '<option value="'.$key['nombre'].'">'.$key['nombre'].'</option>';
  }
  $optionsList.= '</select><p hidden>'.$mail.'</p>';
  return $optionsList;

}

if(sizeof($rows) > 0){
  $lists = "<ul class='heading assignPendingAdv'>
            <li></li>
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
  $contador = 0;
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
    $fechaS = explode("-", $row[25]);
    $fechaSHora = explode(".",explode(" ", $row[25])[1]);
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
    $seguro = '';
    $pause = $row[27];
    $pauseClass = "";
    $visible = '';
    $options = createOptons($agente,$row[0]);
    $textoMensajeria = "Abrir aplicación de Logística";
    if($pause == 1){
      $pauseClass = "pause";
      if($puesto == 'ADV' && $user[0][1] != $row[10])
        $visible = 'style="display:none"';
    }
    $li = '<li class="delete" title="Marcar como cesión recibida"><img id="'.$row[0].'" alt="tick" src="../img/done_FILL0_wght400_GRAD0_opsz24.png"></li>';
    if(($_POST['id']) != 'new')
      $li = '<li title="Envío: ">'.$fechaR[2].'/'.$fechaR[1].'/'.$fechaR[0].'</li>';
    if($row[13] == 1)
      $fragChecked = 'checked="checked"';
    if($row[13] == 1){
      $disgon = '<input type="checkbox" ></input>';
      if($row[18] == 1){
        $disgon = '<input type="checkbox" checked="checked"></input>';
        $seguro = 'SEG';
      }
      if($row[18] == 1 && $puesto == 'ADV' && $row[1] != 'MAT'){
        $envioDisgon = '📦';
        if($row[1] == 'SANTIAGO'){
          $envioDisgon = '🚚';
          $textoMensajeria = "Enviar correo a Disgon";
        }
        if($row[1] == 'VALENCIA')
          $envioDisgon = '';
        if($row[22] == 1)
          $envioDisgon = "✅";
      }
    }
    if($row[16] == 1)
      $btnDestinoPress = 'active-city-press';
    $destino = $row[2];
    $origen = '<span id="origen'.$row[0].'" >'.$row[1].'</span>';
    $destinoSpan = '<span id="destinoBtn'.$row[0].'" class="'.$btnDestinoPress.'" style="cursor: initial">'.$destino.'</span>';
    $classDelete = '';
    $classSend = '';
    $cursor = 'style="cursor: initial"';
    if($puesto == 'ADV'){
      $destinoSpan = '<span id="destinoBtn'.$row[0].'" class="active-city '.$btnDestinoPress.'" >'.$destino.'</span>';
      $classSend = 'class="send"';
      $classDelete = 'class="delete"';
      $btnEnviar = '<span title="Enviar Cesión" id="send'.$row[0].'">📩</span>';
      $cursor = 'style="cursor:pointer"';
      if($row[1] == 'EXT'){
        $textoMensajeria = "Enviar correo a ".ucwords($row[12]);
        $envioDisgon = "🏬";
        if($row[28] != '')
          $envioDisgon = "✅";
        if($row[2] == 'MADRID'){
          $textoMensajeria = "Enviar correo a ".ucwords($row[12])." y placa de Madrid";
          $btnEnviar = '<span title="Enviar Cesión" id="send'.$row[0].'"></span>';
        }
      }
    }
    if($puesto == 'ADV' || $agente == ''){
      $origen = createOptions($row[0],$row[1],$row[12]);
    }
    if($row[10] != $user[0][1])
      $usuarioCesion = $row[10].'<span id="rechazo'.$row[0].'">❌</span>';
    if($row[23] == 1){
      $rechazado = "🚫";
      $rechazadoStyle = 'background-color:#ff000073';
    }
    if($row[15] == 1)
      $btnOrigenPress = 'ledOn';
    if($row[15] == 2)
      $btnOrigenPress = 'ledRed';
    if($row[14] == 1){
      $nfm = 'NM';
      $nfmChecked = 'checked="checked"';
    }

    $rutasDirectas = ["6251-2","78709-1","12752-1","105252-1","105342-1","14075-1"];
    $rutasPreguntar = ["6254-1","78713-1"];
    $rutasPortes = ["12874","14079-1","14101-1","6280-1","14086-1","105247-1","105511-1","105400-1","78665-1","78713-1","105311-1"];

    if($row[1] != 'MAT' && $row[1] != 'EXT'){
      if(in_array($codgClient[$row[1].$row[2].$seguro.$nfm],$rutasPreguntar))
        $important = 'important';
      if(in_array($codgClient[$row[1].$row[2].$seguro.$nfm],$rutasDirectas))
        $important = 'route';
      $numPie = $codgClient[$row[1].$row[2].$seguro.$nfm];
    }
    if($row[1] == 'MAT'){
      $numPie = "$row[12] <p hidden>$row[26]</p>";
    }elseif($row[1] == 'EXT'){
      $numPie = createOptionProvExt($row[0],$row[12]);
    }
    
    $lists .= '
    <ul class="assignPendingAdv" '.$visible.' title="'.++$contador.'" style="'.$rechazadoStyle.'">
    <li><span class="ledOff '.$btnOrigenPress.'" '.$cursor.' title="'.$contador.'">'.$contador.'</span></li>
    <li title="Copiar: Origen > Destino" class="origenCesion">
      '.$origen.$destinoSpan.'
        <span class="copy '.$important.'" style="grid-column: 1 / 4;font-size: medium;">'.$numPie.'</span>
      </li>
      <li title="Destino: " style="display:none">'.$row[2].'</li>
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
        '.$options.'
      </li>
      <li title="Acciones: '.$row[4].'" class="delete" id="'.$row[0].'"><img src="../img/delete_FILL0_wght400_GRAD0_opsz24.png" alt="eliminar" title="Eliminar"><img src="../img/pause24x24.png" class="'.$pauseClass.'" alt="Detener" title="Detener la cesión. No se envía a ADV."><span title="'.$row[24].'">'.$rechazado.'</span></li>
      <li '.$classSend.' >'.$btnEnviar.'<span title="'.$textoMensajeria.'" id="disgon'.$row[0].'">'.$envioDisgon.'</span></li>
      <li '.$classDelete.' style="text-align:center;font-size:small" title="'.explode(" ",$fechaS[2])[0]."/".$fechaS[1]."/".$fechaS[0]." ".$fechaSHora[0].'">'.$usuarioCesion.'</li>
    </ul>';
  }
}

echo $lists;