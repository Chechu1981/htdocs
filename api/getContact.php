<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$rows = $contacts->getPartner(explode(' ',str_replace(",","",$_POST['nombre'])));

echo $rows[0][10];