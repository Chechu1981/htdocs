<?php
include_once '../connection/data.php';

$lists = '';
$contacts = new Contacts();

$rows = $contacts->deleteUser($_POST['id']);
