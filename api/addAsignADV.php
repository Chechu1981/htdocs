<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$userFilds = $contacts->getUserBySessid($_POST['session']);
$user = $userFilds[0][1];

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
    $user
];

$rows = $contacts->newAssigADV($items);
echo $rows;