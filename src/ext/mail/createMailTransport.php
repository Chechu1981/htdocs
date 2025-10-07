<?php

require('../../../helper/phpMailer/phpMailer.php');
require('../../../helper/phpMailer/SMTP.php');

include_once '../../../connection/data.php';
$conexion = new Contacts();

$DIRECCIONES = [
  'MADRID' => 'Carretera de Seseña a Esquivias, Km 0,8 - 45224 Seseña Nuevo (Toledo)',
  'VALENCIA' => 'Carrer dels Bombers, 20 - 46980 PATERNA - VALENCIA',
  'GALICIA' => 'Vía Pasteur 41, CP:15898 Santiago de Compostela (A CORUÑA)',
  'SANTIAGO' => 'Vía Pasteur 41, CP:15898 Santiago de Compostela (A CORUÑA)',
  'BARCELONA' => 'Calle D, nº 41 - Polig. Ind. Zona Franca - 08040 BARCELONA',
  'ZARAGOZA' => 'C/ Río de Janeiro, 3 Polígono Industrial Centrovia 50198 - La Muela - ZARAGOZA',
  'GRANADA' => 'Calle Ronda 4 (P.I. Santa Teresa), 29004 Málaga',
  'MÁLAGA' => 'Calle Ronda 4 (P.I. Santa Teresa), 29004 Málaga',
  'SEVILLA' => 'Carretera de la Esclusa S/N Polígono Industrial ZAL del Puerto de Sevilla, 41011 Sevilla',
  'PALMA' => 'Avda. 16 de Julio, 5 - 07009 SON CASTELLO- PALMA DE MALLORCA'
];

$data = json_decode(file_get_contents("php://input"), true);
$usuario = $data['usuario'];
$id_pedido = $data['pedido'];
$marca = $data['marca'];
$tipo = $data['tipo'];
$proveedor = $data['proveedor'];
$placa = $data['placa'];//Trigrama de la marca

$proveedor = $conexion->getProvExt($marca, $tipo, $proveedor, $placa);
$correoProveedor = $proveedor[0]['mail'] ?? 'sin correo';
$recogidaProveedor = $proveedor[0]['recogida'] ?? 'N';
$direccionProveedor = $proveedor[0]['direccion'] ?? 'desconocido';

$direccionDestino = $DIRECCIONES[$placa] ?? '';

$recogidaProveedor = "<p>Se va ha recibir el siguiente listado de piezas de recambio:</p>";
if($recogidaProveedor == 'S') {
    $direccionDestino = 'Pasaremos a recoger una vez nos hayan cofirmado que el pedido se encuentre en sus instalaciones';
    $recogidaProveedor = "<p>Por favor pasad a recoger este pedido a </p><p><strong>$direccionProveedor</strong></p>";
}

$lineasPedido = $conexion->getExtListByOrder($id_pedido);
$nombreCliente = $lineasPedido[0]['nombre_cliente'].' ('.$lineasPedido[0]['cliente'].')' ?? 'desconocido';
$nombreProveedor = $lineasPedido[0]['proveedor'] ?? 'desconocido';

$pedido = '';
if(count($lineasPedido) == 0) {
    echo 'error';
    exit;
}
$pedido .= "<table>
    <tr>
        <td><strong>Referencia</strong></td>
        <td><strong>Descripción:</strong></td>
        <td><strong>Cantidad:</strong></td>
        <td><strong>Precio sin IVA:</strong></td>
        <td><strong>Descuento de compra</strong></td>
        <td><strong>Descuento de venta</strong></td>
    </tr>";
foreach ($lineasPedido as $linea) {
    $trigrama = $conexion->crearTrigrama($tipo, $marca, $linea['referencia']); 
    $pedido .= "<tr>
            <td>".$trigrama."</td>
            <td>".$linea['designacion']."</td>
            <td>".$linea['cantidad']."</td>
            <td>".number_format($linea['pvp'],2,',','.')." €</td>
            <td>".number_format($linea['dto_compra'],2,',','.')." %</td>
            <td>".number_format($linea['dto_venta'],2,',','.')." %</td>
        </tr>";
}
$pedido .= "</table>";

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';
$head = "<head>
  <title>Nuevo pedido PPCR Otras Marcas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: left;
            padding: 20px;
        }
        .header img {
            max-width: 100%;
            height: auto;
        }
        .content {
            margin-top: 20px;
        }
        .content h1 {
            color: #333;
        }
        .content p {
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
            .header img {
                width: 80%;
            }
        }
        @media (max-width: 400px) {
            .button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>";
$saludo = "<p>Buenos días:</p>";
$date = new DateTime();
if($date->format('H') >= 13) $saludo = "<p>Buenas tardes:</p>";
$body = "<body>
  <div class='container'>
    <div class='header'>
      <img src='https://ppcr.es/img/Logo-PPCR-2022.png' width='100' alt='ChechuParts'>
    </div>
    <div class='content'>
      $saludo
      $recogidaProveedor
      <p><strong>Número de pedido:</strong> $id_pedido</p>
      <p><strong>Cliente:</strong> $nombreCliente</p>
      <p><strong>Proveedor:</strong> $nombreProveedor</p>
      $pedido
      <p>Gracias y un saludo.</p>
    </div>
    <div class='footer'>
      ChechuParts &copy; 2022
    </div>
  </div>
</body>";

$mail->IsSMTP();
$mail->Host       = 'smtp.ppcr.es';
$mail->Port       = 587;
$mail->SMTPDebug  = 1;
$mail->SMTPAuth   = true;
$mail->Username   = 'info@ppcr.es';
$mail->Password   = 'd+#Po)w{ve4jd-';
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->SetFrom('info@ppcr.es', 'Placa de Peiezas y Componentes de Recambio (PPCR)');
$mail->AddReplyTo('no-reply@ppcr.es','no-reply');
$mail->Subject    = 'Nuevo pedido PPCR Otras Marcas'; //$_POST['asunto'];
$mail->MsgHTML($head.$body);

$mail->AddAddress('jesusjulian.martin@stellantis.com', 'NewUser'); //Colocar el correo del proveedor
$mail->AddCC('otro@ejemplo.com', 'Otro Usuario');
$mail->send();
?>