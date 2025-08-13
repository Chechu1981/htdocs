<?php
include_once '../connection/data.php';

$lists = '<h1>No se han encontrado conincidencias</h1>';
$contacts = new Contacts();
$search = str_replace("'","",$_POST['search']);
$rows = $contacts->getRoutesHTMLtest($search.'-');

$PLACAS = [
    'MAD' => 'MADRID',
    'SAN' => 'SANTIAGO',
    'BAR' => 'BARCELONA',
    'ZAR' => 'ZARAGOZA',
    'VAL' => 'VALENCIA',
    'MÁL' => 'MÁLAGA',
    'PAL' => 'PALMA',
    'SEV' => 'SEVILLA'
];

if(sizeof($rows) > 0){
    $lists = '';
    foreach ($rows as $row) { 
        $row[1] == 'GRA' ?  $placa = 'MÁL' : $placa = $row[1];
        array_key_exists($placa, $PLACAS) ? $placa = $PLACAS[$placa] : $placa = 'DESCONOCIDO';
        
        $lists .= '
        <ul>
            <li title="Cliente: ">'.$row[0].'</li>
            <li title="Placa: ">'.$placa.'</li>
            <li title="Corte: ">'.$row[2].'</li>
            <li title="Salida: ">'.$row[3].'</li>
            <li title="Nombre: " id="'.$row[10].'" class="link">'.$row[4].'</li>
            <li title="Teléfono: ">'.$row[5].'</li>
            <li title="Dirección: ">'.$row[6].'</li>
            <li title="Población: ">'.$row[7].'</li>
            <li title="Provincia: ">'.$row[8].'</li>
            <li title="Ruta: ">'.$row[9].'</li>
        </ul>';
    }
}

echo $lists;