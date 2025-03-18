<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$privateKey = '';

if($_POST['private'] == 'true'){
    $privateKey = $contacts->getMailBySsid($_POST['ssId'])[0][0];
}

$items = [
    $_POST['ssId'],
    $_POST['marca'],
    $_POST['placa'],
    $_POST['cuenta'],
    base64_encode($_POST['usr']),
    base64_encode($_POST['pswd']),
    $_POST['web'],
    $_POST['phone'],
    $_POST['tipo'],
    $privateKey,
];

$rows = $contacts->newPass($items);
echo $rows;