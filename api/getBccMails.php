<?php
include_once '../connection/data.php';
$data = file_get_contents("../json/correos.json");
$products = json_decode($data, true);
$lists = '';
$contacts = new Contacts();
$pilot = $_POST['origen'];
if($_POST['origen'] == 'PALMA'){
    $pilot = 'BALEARES';
}
$mails = $products[$_POST['destino']];
$mailsC = $products[$_POST['destinoC']];
$mailsF = $products[$_POST['origenF']];
$arr = ['destino' => $mails,'conCopia' => $mailsC,'fragil' => $mailsF];

$rows = $contacts->getCenter('PPCR '.strtoupper($pilot),'PILOTO ECONOMICO');

foreach($rows as $row){ 
    $arr['origen'] = $row[10];
}

echo json_encode($arr,true);
?>