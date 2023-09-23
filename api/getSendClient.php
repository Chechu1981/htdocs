<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$rows = $contacts->getSendClient($_POST['ncliente'],$_POST['placa']);

echo utf8_decode($rows);