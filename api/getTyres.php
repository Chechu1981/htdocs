<?php
include_once '../connection/data.php';

$lists = '';
$contacts = new Contacts();

$rows = $contacts->getTyresHTML($_POST['width'],$_POST['height'],$_POST['diameter'],$_POST['load_code'],$_POST['speed_index']);

foreach ($rows as $row) { 
    $lists .= '
        <li>'.$row[0].'</li>
        <li>'.$row[1].'</li>
        <li>'.$row[3].'</li>
        <li>'.$row[4].'</li>
        <li>'.$row[5].'</li>
        <li>'.$row[6].'</li>
        <li>'.$row[7].'</li>
        <li>'.$row[8].'</li>
        ';
}

echo $lists.'</ul>';