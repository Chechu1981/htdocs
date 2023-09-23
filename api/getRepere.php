<?php
include_once '../connection/data.php';

$contacts = new Contacts();
$htmlList = '';
$rows = $contacts->getRepereHTML($_POST['search']);
if(count($rows) > 0){
    foreach ($rows as $row) {
        $htmlList .= $row[2] .'</br>';
    }
}else{
    $htmlList .= "No hay coincidencias";
}

echo $htmlList;