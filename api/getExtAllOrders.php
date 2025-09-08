<?php
include_once '../../connection/data.php';
$conexion = new Contacts();

$htmlList = '<ul class="heading">
<li>Pedido</li>
<li>Placa</li>
<li>Cliente</li>
<li>Fecha</li>
<li>Comentario</li>
</ul>';

$rows = $conexion->getExtAllOrders();

foreach ($rows as $row) {
    if($enviado = $row[6]){
        $fecha = date_create($row[6]);
        $enviado = '<i class="fa-solid fa-square-check" title="Enviado: '.date_format($fecha, 'd/m/Y H:i:s'). '"></i>';
    }else{
        $enviado = '<i class="fa-solid fa-pen-to-square" id="edit-'.htmlspecialchars($row[0]).'"></i><i class="fa-solid fa-trash-can" id="delete-'.htmlspecialchars($row[0]).'"></i>';
    }
            
    $htmlList .= '<ul id="'.htmlspecialchars($row[0]).'"><li class="order-item">' . htmlspecialchars($row[0]) . '</li>';
    $htmlList .= '<li class="order-details">' . htmlspecialchars($row[1]) . '</li>';
    $htmlList .= '<li class="order-details">' . htmlspecialchars($row[2]) . '</li>';
    $htmlList .= '<li class="order-details">' . htmlspecialchars($row[3]) . '</li>';
    $htmlList .= '<li class="order-details">' . htmlspecialchars($row[4]) . '</li>';
    $htmlList .= '<li class="order-details">'.$enviado.'</li>';
    $htmlList .= '<li id="lineas'.htmlspecialchars($row[0]).'" class="row-full"></li>';
    $htmlList .= '</ul>';
}

echo $htmlList;