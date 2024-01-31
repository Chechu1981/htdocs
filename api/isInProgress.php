<?php
include_once '../connection/data.php';

$conexion = new Contacts;

$filas = $conexion->is_send($_POST['id']);

echo json_encode($filas[0]);