<?php
include_once '../connection/data.php';

$lists = 'Desconocido';
$contacts = new Contacts();

$rows = $contacts->getRefer(str_replace("'","",$_POST['search']));

if(sizeof($rows) > 0){
    $lists = '';
    foreach ($rows as $row) { 
        $list .= trim($row[3],'000');
        /*$lists .= '
        <ul>
            <li title="Cliente: ">'.$row[0].'</li>
            <li title="Placa: ">'.$row[1].'</li>
            <li title="Corte: ">'.$row[2].'</li>
            <li title="Salida: ">'.$row[3].'</li>
            <li title="Nombre: ">'.$row[4].'</li>
            <li title="Teléfono: ">'.$row[5].'</li>
            <li title="Dirección: ">'.$row[6].'</li>
            <li title="Población: ">'.$row[7].'</li>
            <li title="Provincia: ">'.$row[8].'</li>
            <li title="Ruta: ">'.$row[9].'</li>
        </ul>';*/
    }
}

echo $lists;