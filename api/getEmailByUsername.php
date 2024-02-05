<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$rows = $contacts->getMailByUsername($_POST['usuario']);

if(count($rows) === 1){
    echo json_encode($rows[0]);
}
else
    echo "false";
    