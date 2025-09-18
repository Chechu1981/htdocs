<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$data = json_decode(file_get_contents('php://input'), true);
$marca = $data['marca'] ?? '';
$tipo = $data['tipo'] ?? '';
$proveedor = $data['proveedor'] ?? '';

$proveedores = $contacts->getProvExt($marca, $tipo, $proveedor);
$marca = $contacts->getMarcaExt($marca, $tipo, $proveedor);

$arrayProv = [];
$arrayMarca = [];

foreach ($proveedores as $proveedor) {
    $arrayProv[] = $proveedor;
}
foreach ($marca as $marca) {
    $arrayMarca[] = $marca;
}
echo json_encode([$arrayMarca,$arrayProv]);