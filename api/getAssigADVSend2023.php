<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$user = $contacts->getUserBySessid($_POST['session']);

$rows = $contacts->getAssigPending($_POST['id'],$user);

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
if($_POST['sort'] == 'date')
    $imgDate = "<li>Envío<img alt='arrow' src='../img/sort_desc.png' id='sortEnvio'/></li>";

$agent = '';
$agent_head = '';
if($_POST['id'] != 'new')
    $agent_head = "<li>Agente</li>";

$lists = "<ul class='heading'>
        <li><span>".$imgOrigen."</span> > <span>".$imgDestino."</span></li>
        <li>Emisor</li>
        <li>Agente ADV</li>
        <li>Cliente</li>
        <li>Comentario</li>
        <li>Referencia</li>
        <li>Cantidad</li>
        <li>NFM</li>
        <li>Frágil</li>
        <li>Eliminar</li>
        </ul>"; 

if(sizeof($rows) > 0){
    foreach ($rows as $row) {
        if($_POST['id']!= 'new') {
            $agent = '<li title="Agente">'.$row[10].'</li>';
        }
        $clientName = '';
        //if(count($contacts->getClientHTML($row[3])) > 0)
        //    $clientName = ' - '.$contacts->getClientHTML($row[3])[0][4];
        $fecha = explode(" ", $row[8]);
        $fechaD = explode("-", $fecha[0]);
        $fechaR = explode("-", $row[9]);
        $fragChecked = "";
        $nfmChecked = "";
        $nfm = '';
        $li = '<li class="delete" title="Marcar como cesión recibida"><img id="'.$row[0].'" alt="tick" src="../img/done_FILL0_wght400_GRAD0_opsz24.png"></li>';
        if(($_POST['id']) != 'new')
         $li = '<li title="Envío: ">'.$fechaR[2].'/'.$fechaR[1].'/'.$fechaR[0].'</li>';
        if($row[13] == 1)
            $fragChecked = 'checked="checked"';
        if($row[14] == 1){
            $nfm = 'NM';
            $nfmChecked = 'checked="checked"';
        }
        $lists .= '
        <ul>
            <li title="Copiar: Origen > Destino" class="copy">
                <span class="copy">'.$row[1].'</span> > <span class="copy">'.$row[2].'</span>
                <span class="copy" style="grid-column: 1 / 4;font-size: medium;">'.$codgClient[$row[1].$row[2].$nfm].'</span>
            </li>
            <li title="Destino: " style="display:none">'.$row[2].'</li>
            <li>'.$row[7].'</li>
            <li>'.$row[11].'</li>
            <li title="Cliente: " class="copy" style="font-size: medium">'.$row[3].'</li>
            <li title="Ref. Cliente: " style="display:none">'.$row[12].'</li>
            <li title="Comentario: " class="copy">'.$row[11].'</li>
            <li title="Referencia: " class="copy" style="font-size: medium">'.$row[4].'</li>
            <li title="Cantidad: ">'.$row[5].'</li>
            <li title="NFM: "><input type="checkbox" '.$nfmChecked.'></input></li>
            <li title="Frágil: "><input type="checkbox" '.$fragChecked.'></input></li>
            <li title="Eliminar '.$row[4].': " class="delete" id="'.$row[0].'"><img src="../img/delete_FILL0_wght400_GRAD0_opsz24.png" alt="eliminar"></li>
        </ul>';
    }
}

echo $lists.'<button id="sendMail" style="display:none" >ENVIAR TODOS</button>';