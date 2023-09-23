<?php
include_once '../connection/data.php';
$fileCsvName = md5(date("U"));
$fp = fopen('../csv/'.$fileCsvName.'.csv', 'w');
$list = array(['Fecha Pedido','Referencia','Cantidad','Descripcion','Fiabilidad','N reclamacion','VIN','Comentario','Fentrega','Cuenta']);
$charsetClear = array("'",'"',"#","-");

$contacts = new Contacts();
$htmlList = '<ul class="list-header">
    <li></li>
    <li>Fecha Pedido</li>
    <li>Referencia</li>
    <li>Cantidad</li>
    <li>Descripción</li>
    <li>Fiabilidad</li>
    <li>Nº Reclamación</li>
    <li>VIN</li>
    <li>Obser.</li>
    <li>F.entrega</li>
    <li style="text-align:center">D. entrega</li>
    </ul>';
$rows = $contacts->getPending(
    str_replace($charsetClear,"",$_POST['placa']),
    str_replace($charsetClear,"",$_POST['cliente']),
    str_replace($charsetClear,"",$_POST['ref']),
    str_replace($charsetClear,"",$_POST['envio']));
$cliente = "";
if(count($rows) > 0){
    $contador = 1;
    foreach ($rows as $row) {
        $ncliente = explode('-',$row[2]);
        if($cliente == "")
            $cliente = $row[3];
            array_push($list,['fecha_Pedido'=>$row[1],
            'referencia'=>$row[4],
            'cantidad'=>$row[10],
            'descripcion'=>$row[5],
            'fiabilidad'=>$row[6],
            'nreclamacion'=>$row[8],
            'vin'=>$row[9],
            'comentario'=>$row[13],
            'fentrega'=>$row[12],
            'cuenta'=>@$ncliente[1]]
        );
        if($row[10] == 0)
            $row[10] = '<img src="../img/check_circle_FILL0_wght400_GRAD0_opsz48.png" alt="✅" width="25px" title="Servido"></img>';
        $htmlList .= '<ul class="table-result">
            <li title="">' . $contador++ . '</li>
            <li title="F. pedido: ">'.$row[1] .'</li>
            <li title="Referencia: ">'.$row[4] .'</li>
            <li title="Cantidad: ">'.$row[10] .'</li>
            <li title="Descripción: ">'.$row[5] .'</li>
            <li title="Fiabilidad: ">'.$row[6] .'</li>
            <li title="Nº reclamación: ">'.$row[8] .'</li>
            <li title="VIN: ">'.$row[9] .'</li>
            <li title="Comentario: " class="small-coment">'.$row[13] .'</li>
            <li title="Fecha entrega: ">'.$row[12] .'</li>
            <li title="D. envío: ">'.@$ncliente[1] .'</li>
            </ul>';
    }
}else{
    $htmlList .= "No hay coincidencias";
}

foreach ($list as $fields) {
    fputcsv($fp, $fields,";");
}

fclose($fp);

echo "<h3 id='$fileCsvName'>Cliente: ".$_POST['cliente']." * <span style='font-size: small'>".count($rows). " lineas</span></h3>".$htmlList;