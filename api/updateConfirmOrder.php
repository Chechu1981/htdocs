<?php

include_once '../connection/data.php';
$conexion = new Contacts();

$conexion->create_csv($_POST['id']);

// Actualiza el pedido a enviado indicando la fecha de envío.
$conexion->updateConfirmOrderExtBrand($_POST['id']);

echo 'ok';