<?php
include_once '../connection/data.php';

$conexion = new Contacts();

$rows = $conexion->getExtMails($_POST['placa']);

echo json_encode($rows);