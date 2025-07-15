<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$rows = $contacts->getDto($_POST['codDto']);

$arr = array('descuento' => $rows[0]['dto']);
        
echo json_encode($arr);