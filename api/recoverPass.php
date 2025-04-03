<?php
include_once '../connection/data.php';

$contacts = new Contacts();
$rows = 0;

if(strlen($_POST['pass']) > 7)
    $rows = $contacts->updateMailKeyExist($_POST['key'], $_POST['email'], base64_encode($_POST['pass']));

if($rows > 0){
    echo "true";
}else
    echo "false";