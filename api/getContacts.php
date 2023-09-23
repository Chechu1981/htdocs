<?php
include_once '../connection/data.php';

$contacts = new Contacts();
$htmlList = '';
$rows = $contacts->getContactsHTML($_POST['search']);

foreach ($rows as $row) {
    $htmlList .='<ul>
        <li>'.strtoupper($row[6]).'</li>
        <li>'.$row[8].'</li>
        <li>'.$row[7].'</li>
        <li>'.$row[5].'</li>
        <li>'.$row[2].'</li>
        <li>'.$row[1].'</li>
        <li>'.$row[3].'</li>
        <li>'.$row[7].'</li>
        </ul>';
}

echo $htmlList;