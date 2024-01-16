<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$user = $contacts->getUserBySessid($_POST['id']);

$rows = $contacts->getAssigPending($_POST['id'],$user[0][5]);

$dataCliente = file_get_contents("../json/cesionesCliente.json");
$codgClient = json_decode($dataCliente, true);
$data = file_get_contents("../json/cesiones.json");
$codg = json_decode($data, true);
$agent = '';
$agent_head = '';
if($_POST['id'] != 'new') {
    $agent_head = "<li>Agente</li>";
}

$lists ="<ul class='heading'>
            <li><span>Origen</span> > <span>Destino</span></li>
            <li style='display:none'>Destino</li>
            <li>Cliente</li>
            <li>Ref. Cliente</li>
            <li>Comentario</li>
            <li>Referencia</li>
            <li>Cantidad</li>
            <li>PVP</li>
            <li>Pedido</li>
            <li>Frágil</li>
            <li></li>
            <li></li>
            ".$agent_head."
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
        $checked = "";
        $li = '<li class="delete" title="Marcar como cesión recibida"><img id="'.$row[0].'" alt="tick" src="../img/done_FILL0_wght400_GRAD0_opsz24.png"></li>';
        if(($_POST['id']) != 'new')
         $li = '<li title="Envío: ">'.$fechaR[2].'/'.$fechaR[1].'/'.$fechaR[0].'</li>';
        if($row[13] == 1)
            $checked = 'checked="checked"';
        $lists .= '
        <ul>
            <li title="Copiar: Origen > Destino" class="copy">
                <span class="copy">'.$row[1].'</span> > <span class="copy">'.$row[2].'</span>
                <span class="copy">'.$codgClient[$row[1].$row[2]].'</span> > <span class="copy">'.$codg[$row[1].$row[2]].'</span>
            </li>
            <li title="Destino: " style="display:none">'.$row[2].'</li>
            <li title="Cliente: ">'.$row[3].'</li>
            <li title="Ref. Cliente: "class="copy">'.$row[12].'</li>
            <li title="Comentario: " class="copy">'.$row[11].'</li>
            <li title="Referencia: " class="copy">'.$row[4].'</li>
            <li title="Cantidad: ">'.$row[5].'</li>
            <li title="PVP: "><input type="text" value="'.$row[6].'"></input></li>
            <li title="Pedido: "><input type="text" value="'.$row[7].'"></input></li>
            <li title="Frágil: "><input type="checkbox" '.$checked.'></input></li>
            <li title="Eliminar '.$row[4].': " class="delete" id="'.$row[0].'"><img src="../img/delete_FILL0_wght400_GRAD0_opsz24.png" alt="eliminar"></li>
            <li title="enviar" class="send" id="send'.$row[0].'">📩</li>
        </ul>';
    }
}

echo $lists.'<button id="sendMail" style="display:none" >ENVIAR TODOS</button>';