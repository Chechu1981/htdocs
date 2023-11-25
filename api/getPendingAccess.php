<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$user = $contacts->getPendingAccessSelect();

var_dump($user);
