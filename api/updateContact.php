<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$items = [
    $_POST['id'],
    $_POST['centro'],
    $_POST['entidad'],
    $_POST['equipo'],
    $_POST['nombre'],
    $_POST['puesto'],
    $_POST['ext'],
    $_POST['nlargo'],
    $_POST['movil'],
    $_POST['ncorto'],
    $_POST['correo']];

$rows = $contacts->updateContacts($items);
echo $rows;