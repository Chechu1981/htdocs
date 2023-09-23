<?php

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = new Spreadsheet();

$name = explode('.',$_FILES['file']['name'])[0];
$filename = $_FILES['file']['tmp_name'];
$handle = fopen($filename, "rb");
$filenameout = '../downloads/'.$name.'.xlsx';

$data = ['AUT (Tarifa total) AUD (Tarifa Delta)',
'FECHA DE CREACION',
'FECHA SOLICITUD PRECIO',
'ORGANIZACION COMERCIAL',
'PAIS',
'LISTA DE PRECIOS',
'LISTA DE PRECIOS DISTRIBUIDOR',
'MONEDA',
'REFERENCIA',
'DESIGNACION',
'DESIGNACION 2do idioma',
'MARCA (C P W)',
'CODIGO TIPO',
'TIPO DE IVA (0 exento, 1 completo, 3 reducido)',
'INDICADOR PRECIO NETO',
'PRECIO UNITARIO COMPRA (Si ""1"" en acmpo anterior)',
'PVP (sin IVA)',
'CODIGO REMPLAZAMIENTO',
'LISTA DE REMPLAZAMIENTO',
'REFERENCIA REMPLAZANTE',
'UV (=UC)',
'PESO NETO (gr)',
'CODIGO DESCUENTO',
'Column1.24',
'CODIGO TARIC',
'INDICE',
'SEGMENTO',
'CRENEAU',
'FAMILIA DE MARKETING',
'GRUPO DE MERCANCIAS',
'PROVISION',
'PRECIO PROVISION (sin IVA)',
'CODIGO ECHANGE STANDARD (E, N, P)',
'ORIGEN PIEZA (IMPORTANTE)',
'CODIGO ALMACENADO (No usa)',
'REFERENCIA SAP',
'TIPO MATERIAL (no usa)',
'GRUPO ENSAMBLAJE (No usa)',
'CANTIDAD DE REF REMPLAZANTES',
'REFERENCIA REMPLAZANTE 2',
'CANTIDAD (REMPLAZANTE 2)',
'REFERENCIA REMPLAZANTE 3',
'CANTIDAD (REMPLAZANTE 3)',
'REFERENCIA REMPLAZANTE 4',
'CANTIDAD (REMPLAZANTE 4)',
'REFERENCIA REMPLAZANTE 5',
'CANTIDAD (REMPLAZANTE 5)',
'REFERENCIA REMPLAZANTE 6',
'CANTIDAD (REMPLAZANTE 6)',
'STATUT ADV',
'PRESENCIA LISTA PRECIOS (no usa)',
'DESIGNACION 3er idioma',
'DESIGNACION 4to idioma',
'TIPO DE MODIFICACION ( si tarifa DELTA *5)',
'FRECUENCIA VENTA (No usa)',
'FAMILIA DE COMPRAS',
'CODIGO EAN',
'CODIGO DESCUENTO IAM',
'RELLENO',
'INDICADOR IAM ( Y)',
'INDICADOR PIEZA CON CADUCIDAD (O)',
'MESES DE STOCAJE (si caducidad)',
'CTU',
'FAMILIA DE NEUMATICOS',
'DIMENSIONES DE NEUMATICOS',
'NOMBRE COMERCIAL NEUMATICO',
'LARGO (mm, 3 decimales)',
'ANCHO (mm, 3 decimales)',
'ALTO (mm, 3 decimales',
'VOLUMEN (mm, 3 decimales)',
'CARACTERISTICA DEL INDICADOR',
'DESIGNACION LARGA',
'EFICIENCIA COMBUSTIBLE',
'CALIDAD RETENCION CARRETERA',
'RUIDO CONDUCCION',
'CLASE DE ONDA',
'Column1.77',
'Column1.78'
];

$sheet = $spreadsheet->getActiveSheet();

$cont = 0;
$header = array();
foreach ($data as $cabecera){
  array_push($header,htmlspecialchars(utf8_encode($cabecera)));
}
$sheet->fromArray([$header],null,'A1');

$writer = new Xlsx($spreadsheet);

// Guardar el archivo en el disco
$writer->save($filenameout);

/*Vuelco el fichero en un array  */
$cont = 1;
while(! feof($handle)){
  $spreadsheet = IOFactory::load($filenameout);
  $sheet = $spreadsheet->getActiveSheet();
  $lastRow = $sheet->getHighestRow();
  $fileLine = fread($handle,5208);
  $datos = array();
  for($i = 0; $i < 8 ; $i++){
    $linea = lstrim(tr_replace([' ','\n','\r'],'',(str_split($fileLine,651)[$i])));
    array_push($datos,[
      substr($linea,0,3),
      substr($linea,3,8),
      substr($linea,11,8),
      substr($linea,19,4),
      substr($linea,23,3),
      substr($linea,26,2),
      substr($linea,28,1),
      substr($linea,29,5),
      substr($linea,34,18),
      substr($linea,52,15),
      substr($linea,67,15),
      substr($linea,82,1),
      substr($linea,83,3),
      substr($linea,86,1),
      substr($linea,87,1),
      substr($linea,88,11),
      floatval(substr($linea,99,11))/100,
      substr($linea,110,1),
      substr($linea,111,7),
      substr($linea,118,18),
      substr($linea,136,5),
      substr($linea,141,15),
      substr($linea,156,2),
      substr($linea,158,3),
      substr($linea,161,17),
      substr($linea,178,4),
      substr($linea,182,4),
      substr($linea,186,5),
      substr($linea,191,5),
      substr($linea,196,1),
      substr($linea,197,18),
      floatval(substr($linea,215,11))/100,
      substr($linea,226,1),
      substr($linea,227,1),
      substr($linea,228,1),
      substr($linea,229,13),
      substr($linea,242,3),
      substr($linea,245,2),
      substr($linea,247,6),
      substr($linea,253,18),
      substr($linea,271,6),
      substr($linea,277,18),
      substr($linea,295,6),
      substr($linea,301,18),
      substr($linea,319,6),
      substr($linea,325,18),
      substr($linea,343,6),
      substr($linea,349,18),
      substr($linea,367,6),
      substr($linea,373,2),
      substr($linea,375,3),
      substr($linea,378,1),
      substr($linea,379,15),
      substr($linea,379,15),
      substr($linea,394,2),
      substr($linea,409,3),
      substr($linea,411,13),
      substr($linea,413,6),
      substr($linea,427,12),
      substr($linea,433,1),
      substr($linea,445,1),
      substr($linea,446,3),
      substr($linea,447,5),
      substr($linea,450,3),
      substr($linea,455,26),
      substr($linea,458,31),
      substr($linea,484,15),
      substr($linea,515,15),
      substr($linea,530,15),
      substr($linea,545,15),
      substr($linea,560,30),
      substr($linea,575,30),
      substr($linea,605,30),
      substr($linea,635,1),
      substr($linea,636,1),
      substr($linea,640,1),
      substr($linea,641,8)]);
    }
    for ($li = 1; $li < count($datos); $li++) {
      $cont++; // Incrementar el número de fila para evitar sobrescribir la cabecera
      $sheet->fromArray([$datos[$li]], null, 'A' . $cont);
    }
    $writer = new Xlsx($spreadsheet);

    // Guardar el archivo en el disco
    $writer->save($filenameout);
}

fclose($handle);

echo 'Archivo creado exitosamente: <a href="'.$filenameout.'">'.$name.'.xlsx</a>';

?>