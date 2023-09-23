<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$usr = $contacts->getUserBySessid($_POST['userId']);

$rows = $contacts->setColor($_POST['color'],$usr);
echo $rows;