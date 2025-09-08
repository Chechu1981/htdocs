<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$data = json_decode(file_get_contents('php://input'), true);
$marca = $data['marca'] ?? '';
$tipo = $data['tipo'] ?? '';
$proveedor = $data['proveedor'] ?? '';

$rows = $contacts->getProvExt($marca, $tipo, $proveedor);

echo json_encode($rows);