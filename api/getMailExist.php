<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$rows = $contacts->getMailExist($_POST['mail']);

if(count($rows) > 0){
    $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(5/strlen($x)) )),1,5);    
    echo $random;
}else
    echo false;