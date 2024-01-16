<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$userFilds = $contacts->getUserBySessid($_POST['session']);
$user = $userFilds[0][1];

$items = [
    $_POST['origen'],
    $_POST['destino'],
    $_POST['cliente'],
    $_POST['ref'],
    $_POST['pvp'],
    $_POST['pedido'],
    date("Y-m-d H:i:s"),
    $_POST['cantidad'],
    $user,
    $_POST['comentario']
];

$rows = $contacts->newAssig($items);
echo $rows;