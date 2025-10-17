<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$nplaca = [
    "DO"=>"",
    "027130L"=>"PALMA",
    "027135M"=>"BARCELONA",
    "027120K"=>"GRANADA",
    "027015L"=>"MADRID",
    "027066M"=>"VALENCIA",
    "027110G"=>"SEVILLA",
    "027115E"=>"VIGO",
    "027125R"=>"ZARAGOZA"
];

$nplate = $nplaca[$_POST['placa']];
$client = $contacts->getClientNameByPlate($_POST['cliente'],substr($nplate,0,3));

// Obetener la Ip del cliente
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'DESCONOCIDO';
    return $ipaddress;
}

$rows = $contacts->newSelectPending(
    get_client_ip(),
    $nplate,
    $_POST['cliente'],
    $_POST['referencia'],
    $_POST['envio'],
    $client[6]);
?>