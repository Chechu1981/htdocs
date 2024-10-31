<?php
include_once '../connection/data.php';
$conexion = new Contacts();

$rows = $conexion->updateAlert($_POST['active'], $_POST['coment']);