<?php
include_once '../connection/data.php';
$contacts = new Contacts();
//echo $_SERVER['REMOTE_ADDR'];
$contacts->newRecordDownloadFile($_SERVER['REMOTE_ADDR']);
?>
