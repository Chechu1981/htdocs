<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$charsetExtract = array("'");

$username = str_replace($charsetExtract, "",$_POST['usr']);
$userpsw = str_replace($charsetExtract, "",$_POST['psw']);

$rows = $contacts->getUser($username,$userpsw);

if(sizeof($rows) === 1){
    $id = hash('sha256',Date('U'));
    $rows[0]['hash'] = $id;
    $strbks = array('[',']');
    $oldUsr = '['.str_replace($strbks,'',file_get_contents('../json/sesiones.json')) .','. str_replace($strbks,'',json_encode($rows)).']';
    $user = file_put_contents('../json/sesiones.json',$oldUsr);
    echo $id;
}
else
    echo "false";
    