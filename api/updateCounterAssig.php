<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$usuario = "ROBOT";
$hash = '';
$puesto = 'ADV';
$user = $contacts->getUserBySessid($_POST['id']);
if(count($user)>0){
  $usuario = $user[0][1];
  $hash = $user[0][5];
  $puesto = $user[0][4];
}

$nuevas = $contacts->getAssigCountNew($usuario,$puesto,'')[0][0];
$allAdvAssigns = $contacts->getAssigCountNew($usuario,$puesto,'all')[0][0];
$enCurso = $contacts->getAssigCountNew($usuario, $puesto,'ready')[0][0];
$contadores = ["nuevas" => $nuevas,"todas" => $allAdvAssigns,"enCurso" => $enCurso];

echo json_encode($contadores);