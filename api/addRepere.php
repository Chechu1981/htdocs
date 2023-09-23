<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$items = explode(',',$_POST['index']);
$sizeRp = count($items);

for($i = 0; $i < $sizeRp; $i = $i + 2)
    $contacts->addRepere($items[$i],$items[$i+1]);

echo 'ok';