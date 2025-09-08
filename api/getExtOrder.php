<?php
include_once '../connection/data.php';
$conexion = new Contacts();

$htmlList = '';

$rows = $conexion->getExtOrderById($_GET['id']);
$htmlList .= '<div class="order-list order-headers">
    <span class="order-header">Referencia</span>
    <span class="order-header">Cantidad</span>
    <span class="order-header">Designación</span>
    <span class="order-header">Tipo</span>
    <span class="order-header">PVP</span>
    <span class="order-header">Dto compra</span>
    <span class="order-header">Dto venta</span>
    </div>';

foreach ($rows as $row) {
    $htmlList .= '<div class="order-list">';
        $htmlList .= '<span class="order-item">' . htmlspecialchars($row[3]) . '</span>';
        $htmlList .= '<span class="order-item">' . htmlspecialchars($row[4]) . '</span>';
        $htmlList .= '<span class="order-item">' . htmlspecialchars($row[5]) . '</span>';
        $htmlList .= '<span class="order-item">' . htmlspecialchars($row[7]) . '</span>';
        $htmlList .= '<span class="order-item">' . htmlspecialchars($row[9]) . '</span>';
        $htmlList .= '<span class="order-item">' . htmlspecialchars($row[10]) . '</span>';
        $htmlList .= '<span class="order-item">' . htmlspecialchars($row[11]) . '</span>';
    $htmlList .= '</div>';
}

echo $htmlList;