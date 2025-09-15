<?php
include_once '../connection/data.php';

$conexion = new Contacts();
$datos = json_decode(file_get_contents("php://input"), true);
$rows = $conexion->getExtMails($datos['placa']);
$proveedor = $conexion->getExtMailProv($datos['placa'],$datos['proveedor']);
if(count($proveedor) <= 0){
    $proveedor = [''];
}else{
    $proveedor = $proveedor[0];
}
if(count($rows) <= 0){
    $rows = [''];
}else{
    $rows = $rows[0];
}
echo json_encode([$rows,$proveedor]);