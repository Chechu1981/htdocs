<?php

$CARACTERES = "'\"[`¡!@#$%&*()_+/=|<>¿?{}\\[\\]~-] .,Ç^·%ºª";

include_once '../connection/data.php';
$datos = json_decode(file_get_contents('php://input'), true);
$conexion = new Contacts();
$userFilds = $conexion->getUserBySessid($datos['idUsuario']);
$user = $userFilds[0][1];
$datos['referencia'] = str_replace($CARACTERES, '', $datos['referencia']);

$conexion->updateExtLine($datos['id'],
                        $datos['cliente'],
                        $datos['nombre_cliente'],
                        $datos['comentario'],
                        $datos['tipo'],
                        $datos['marca'],
                        $datos['referencia'],
                        $datos['cantidad'],
                        $datos['designacion'],
                        $datos['familia'],
                        $datos['proveedor'],
                        $datos['pvp'],
                        $datos['dto_compra'],
                        $datos['dto_venta']);  


