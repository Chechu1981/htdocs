<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->SelectsClientPending($_POST['day']);
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

$htmlList = "
    <table class='listPendig'>
        <tr>
            <th>Placa</th>
            <th>Cliente</th>
            <th>Número</th>
            <th>D. Envío</th>
            <th>Referencia</th>
            <th>IP</th>
            <th>Fecha</th>
        </tr>";
foreach($rows as $consults){
    $htmlList .= "
    <tr>
        <td>".$consults[4]."</td>
        <td>".$consults[8]."</td>
        <td>".$consults[2]."</td>
        <td>".$consults[3]."</td>
        <td>".$consults[5]."</td>
        <td>".$consults[1]."</td>
        <td>".$consults[6]."</td>
    </tr>";
};

echo $htmlList . "</table><div id='secondTable'><div>";