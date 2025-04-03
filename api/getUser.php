<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$username = @$_POST['usr'];
$userpsw = @$_POST['psw'];

$rows = $contacts->getUser($username,base64_encode($userpsw));

if(count($rows) === 1){
    echo "true";
}
else
    echo "false";
