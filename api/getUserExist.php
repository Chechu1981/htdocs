<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$rows = $contacts->getUserExist($_POST['usuario']);

if(count($rows) > 0){
    echo true;
}else
    echo false;