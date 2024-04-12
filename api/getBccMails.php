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
if($_POST['origen'] == 'PALMA'){
    $pilot = 'BALEARES';
}

$mails = $products[$destino];
$mailsC = $products[$destinoC];
$mailsF = $products[$origenF];
$arr = ['destino' => $mails,'conCopia' => $mailsC,'fragil' => $mailsF];

$rows = $contacts->getCenter('PPCR '.strtoupper($pilot),'PILOTO ECONOMICO');

foreach($rows as $row){ 
    $arr['origen'] = $row[10];
}

echo json_encode($arr,true);
?>