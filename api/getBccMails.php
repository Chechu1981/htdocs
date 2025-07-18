<?php
include_once '../connection/data.php';
$data = file_get_contents("../json/correos.json");
$products = json_decode($data, true);
$lists = '';
$contacts = new Contacts();
$pilot = $_POST['origen'];
$destino = $_POST['destino'];
$destinoC = $_POST['destinoC'];
$origenF = $_POST['origenF'];
$origenOrigen = $_POST['mailsOrigen'];
if($_POST['origen'] == 'PALMA'){
    $pilot = 'BALEARES';
}
if($_POST['origen'] == 'MAT' || $_POST['origen'] == 'EXT'){
    $origenF = $_POST['destino']."F";
}

$mails = $products[$destino];
$mailsC = $products[$destinoC];
$mailsF = $products[$origenF];
$mailsOrigen = $products[$origenOrigen];
$arr = ['destino' => $mails,'conCopia' => $mailsC,'fragil' => $mailsF, 'mailsOrigen' => $mailsOrigen];

$rows = $contacts->getCenter('PPCR '.strtoupper($pilot),'PILOTO ECONOMICO');

foreach($rows as $row){ 
    $arr['origen'] = $row[10];
}

echo json_encode($arr,true);
?>