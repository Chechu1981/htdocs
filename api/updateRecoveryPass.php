<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$privateKey = $contacts->updatePassRecovery($_POST['mail'], $_POST['key']);

echo $privateKey;