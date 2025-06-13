<?php
include_once '../connection/data.php';

$contacts = new Contacts();
$htmlList = '';
$rows = $contacts->getRepereHTML($_POST['search']);
if(count($rows) > 0){
    foreach ($rows as $row) {
        $htmlList .= "
                    <input id='rep$row[0]' value='$row[1]'></input>
                    <input id='ref$row[0]' value='$row[2]'></input>
                    <span class='edit-repere' id='edit$row[0]' alt='guardar'>💾</span>
                    <span class='delete-repere' id='delete$row[0]' alt='eliminar'>❌</span>
                    ";
    }
}else{
    $htmlList .= "No hay coincidencias";
}

echo $htmlList;