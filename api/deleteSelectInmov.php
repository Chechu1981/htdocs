<?php
include_once '../connection/data.php';

$lists = '';
$contacts = new Contacts();

$rows = $contacts->deleteSelectInmov($_POST['id'],$_POST['calculo']);
