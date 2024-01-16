<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$rows = $contacts->getUserBySessid($_POST['id']);

if(count($rows) === 1){
    echo $rows[0][1];
}
else
    echo "false";
    