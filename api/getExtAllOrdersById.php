<?php
include_once '../connection/data.php';
$conexion = new Contacts();

$rows = $conexion->getExtAllOrdersById($_GET['id']);

echo json_encode($rows);