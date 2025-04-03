<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$rows = $contacts->getMailKeyExist($_POST['key'], $_POST['email']);

if($rows > 0){
    echo "true";
}else
    echo "false";