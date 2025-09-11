<?php
include_once '../connection/data.php';
$conexion = new Contacts();

$rows = $conexion->getExtListByOrder($_GET['id']);

/*
if (!$rows) {
    echo '<p>No hay pedidos realizados</p>';
}else{
    echo json_encode($rows);
}*/
echo json_encode($rows);
