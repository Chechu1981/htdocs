<?php
$CODETIPO = [
  "IAM" => 'Z',
  "OEM" => 'M'
];

$CODEPROVEEDOR = [
  "RECALVI" => 'REC',
  "REC. ORENSE" => 'ROU',
  "MISTER AUTO" => 'MAT',
  "BRUGÉS GAVÀ" => 'BGA',
  "BPARTS" => 'BPA',
  "GRUPO VW" => 'VAG',
  "FORD" => 'FOR',
  "RENAULT" => 'REN',
  "BMW" => 'BMW',
  "AUDI" => 'AUD',
  "AIXAM" => 'AIX',
  "CHEVROLET" => 'CHE',
  "CUPRA" => 'CPR',
  "GOOD YEAR" => 'GOO',
  "HONDA" => 'HON',
  "HYUNDAI" => 'HYU',
  "JAGUAR" => 'JAG',
  "KENDA" => 'KEN',
  "KIA" => 'KIA',
  "LAFUENTE" => 'LAF',
  "LAND ROVER" => 'LAN',
  "LEXUS" => 'LEX',
  "SPANESI-MARTECH" => 'MAR',
  "MAZDA" => 'MAZ',
  "MERCEDES" => 'MER',
  "MITSUBISHI" => 'MIT',
  "MOVELCO MOBILITY" => 'MOV',
  "LIQUIDOS MT" => 'MT',
  "NISSAN" => 'NIS',
  "PORSCHE" => 'POR',
  "SAAB" => 'SAA',
  "SAM" => 'SAM',
  "SSANYONG" => 'SAN',
  "SEAT" => 'SEA',
  "BAHCO" => 'SNA',
  "SKODA" => 'SKO',
  "SUBARU" => 'SUB',
  "SUREYA" => 'SUR',
  "SUZUKI" => 'SUZ',
  "TAPI. VIGUESA" => 'TAP',
  "TOTAL" => 'TOT',
  "TOYOTA" => 'TOY',
  "VOLVO" => 'VOL',
  "VOLKSWAGEN" => 'VWN',
  "JUMASA" => 'JUM',
  "PHIRA" => 'PHI',
  "ELOY" => 'ELO',
  "SAMOA" => 'SMA'
];

$CODEFAMILIA = [
  "CARROCERIA IAM STELLANTIS" => '01ZS',
  "CARROCERIA IAM NOSTELLANTIS" => '01ZO',
  "MECANICA IAM STELLANTIS" => '03ZS',
  "MECANICA IAM NOSTELLANTIS" => '03ZO',
  "REMANUFACTURADO IAM STELLANTIS" => '40ZS',
  "REMANUFACTURADO IAM NOSTELLANTIS" => '40ZO',
  "CARROCERIA OEM NOSTELLANTIS" => '01M',
  "MECANICA OEM NOSTELLANTIS" => '03M',
  "REMANUFACTURADO OEM NOSTELLANTIS" => '40M'
];

function trigrama($tipo,$proveedor,$referencia){
  global $CODETIPO;
  return "Z".$CODETIPO[$tipo].$proveedor.$referencia;
}

$lineas = ['REFERENCIA;DESIGNACION;FAMILIA;FAMILIA INTERNA'];
foreach(json_decode($_POST['lineas']) as $linea){
  $referencia = strtoupper($linea->referencia);
  $cantidad = $linea->cantidad;
  $designacion = strtoupper($linea->designacion);
  $familiaParts = strtoupper($linea->familia);
  $tipo = $_POST['tipo'];
  $trigrama = trigrama($_POST['tipo'], $_POST['marca'],$referencia);
  $familia = $CODEFAMILIA["$familiaParts $tipo NOSTELLANTIS"];
  array_push($lineas, "$trigrama;$designacion;$familia;006");
}

echo json_encode($lineas);