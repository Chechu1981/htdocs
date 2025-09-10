<?php
include_once '../connection/data.php';
$conexion = new Contacts();

$rows = $conexion->getExtAllOrdersSearch($_GET['placa'],$_GET['busqueda']);
$htmlList = '';

$htmlList .= '<ul class="order-list-search order-headers">
    <li class="order-header">Placa</li>
    <li class="order-header">Proveedor</li>
    <li class="order-header">Marca</li>
    <li class="order-header">Cliente</li>
    <li class="order-header">Referencia</li>
    <li class="order-header">Designación</li>
    <li class="order-header">Cant</li>
    <li class="order-header">Dto. C</li>
    <li class="order-header">Dto. V</li>
    <li class="order-header">Comentario</li>
    <li class="order-header">FechaEnvio</li>
    <li class="order-header">Estado</li>
    </ul>';

foreach ($rows as $row) {
    $estado = '<i class="fa-solid fa-hourglass-start" title="Sin enviar"></i>';
    if($row['fechaenvio'] != '0000-00-00 00:00:00')
        $estado = '<i class="fa-solid fa-truck" title="Enviado"></i>';
    if($row['fecharecibido'] != '0000-00-00 00:00:00')
        $estado = '<i class="fa-solid fa-square-check" title="Recibido"></i>';

    $htmlList .= '<ul class="order-list-search" id="' . $row['id_pedido'] . '">';
    $htmlList .= '<li class="order-item">' . htmlspecialchars($row['placa']) . '</li>';
    $htmlList .= '<li class="order-item">' . htmlspecialchars($row['proveedor']) . '</li>';
    $htmlList .= '<li class="order-item">' . htmlspecialchars($row['marca']) . '</li>';
    $htmlList .= '<li class="order-item">' . htmlspecialchars($row['cliente'].' '.$row['nombre_cliente']) . '</li>';
    $htmlList .= '<li class="order-item">' . htmlspecialchars($row['referencia']) . '</li>';
    $htmlList .= '<li class="order-item">' . htmlspecialchars($row['designacion']) . '</li>';
    $htmlList .= '<li class="order-item">' . htmlspecialchars($row['cantidad']) . '</li>';
    $htmlList .= '<li class="order-item">' . htmlspecialchars($row['dto_compra']) . '</li>';
    $htmlList .= '<li class="order-item">' . htmlspecialchars($row['dto_venta']) . '</li>';
    $htmlList .= '<li class="order-item">' . htmlspecialchars($row['comentario']) . '</li>';
    $htmlList .= '<li class="order-item">' . htmlspecialchars($row['fecha']) . '</li>';
    $htmlList .= '<li class="order-item">' . $estado . '</li>';
    $htmlList .= '</ul>';
}

echo $htmlList;