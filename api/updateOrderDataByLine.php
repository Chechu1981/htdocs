<?php

use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date;

include_once '../connection/data.php';
$datos = json_decode(file_get_contents('php://input'), true);
$conexion = new Contacts();
$userFilds = $conexion->getUserBySessid($datos['idUsuario']);
$user = $userFilds[0][1];
$conexion->updateExtProvLinesByOrderId($datos['tipo'],
                        $datos['marca'],
                        $datos['proveedor'],
                        $datos['numpedido']);  


