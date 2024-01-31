<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$rows = $contacts->getUserBySessid($_POST['id']);

if(count($rows) === 1){
    echo json_encode($rows[0]);
}
else
    echo "false";
    