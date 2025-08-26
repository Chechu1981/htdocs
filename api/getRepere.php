<?php
include_once '../connection/data.php';

$contacts = new Contacts();
$htmlList = '';
$rows = $contacts->getRepereHTML($_POST['search']);
if(count($rows) > 0){
    foreach ($rows as $row) {
        $htmlList .= '<div class="copy">'.$row[2] .'</div></br>';
    }
}else{
    $htmlList .= "No hay coincidencias";
}

echo $htmlList;