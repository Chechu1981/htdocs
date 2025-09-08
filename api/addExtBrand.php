<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$data = json_decode(file_get_contents("php://input"), true);
$userFilds = $contacts->getUserBySessid($data['idUsuario']);
$user = $userFilds[0][1];

$items = [
    'tipo' => $data['tipo'],
    'id_pedido' => $data['numPedido'],
    'marca' => $data['marca'],
    'proveedor' => $data['proveedor'],
    'ref' => $data['ref'],
    'units' => $data['units'],
    'coment' => $data['coment'],
    'family' => $data['family'],
    'pvp' => $data['pvp'],
    'dtoCompra' => $data['dtoCompra'],
    'dtoVenta' => $data['dtoVenta'],
    'user' => $user,
    'fecha' => date("Y-m-d H:i:s"),
    'cliente' => $data['cliente'],
    'placa' => $data['placa'],
    'comentario' => $data['comentario']
];

$rows = $contacts->addExtBrandLine($items);
echo $rows;