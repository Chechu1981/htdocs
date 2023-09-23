<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$user = $contacts->getUserBySessid($_POST['session']);

$items = [
    $_POST['origen'],
    $_POST['destino'],
    $_POST['cliente'],
    $_POST['refClient'],
    $_POST['comentario'],
    $_POST['ref'],
    $_POST['pvp'],
    $_POST['cantidad'],
    $_POST['frag'],
    $_POST['nfm'],
    $user,
    $_POST['pedido'],
    @$_POST['disgon']
];

$rows = $contacts->newAssigADV2023($items);
echo $rows;