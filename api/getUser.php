<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$charsetExtract = array("'");

$username = str_replace($charsetExtract, "",@$_POST['usr']);
$userpsw = str_replace($charsetExtract, "",@$_POST['psw']);

$rows = $contacts->getUser($username,$userpsw);


if(count($rows) === 1){
    echo $rows[0];
}
else
    echo "false";
