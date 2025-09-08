<?php
include_once '../connection/data.php';
$conexion = new Contacts();

$id = $_GET['id'];
$response = $conexion->deleteExtLine($id);

echo $response;