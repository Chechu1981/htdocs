<?php


include_once '../connection/data.php';
$contacts = new Contacts();

$filename=$_FILES["file"]["name"];
$info = new SplFileInfo($filename);
$extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);

$filename = $_FILES['file']['tmp_name'];
$handle = fopen($filename, "r");
$addHistory = array();
$charset = array('=', '"');
$htmlList = "";


/*Vuelco el fichero en una array */
$contador = 0;
while(($data = fgetcsv($handle, 1000, ";")) !== FALSE ){
  array_push($addHistory,[$data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6],
  $data[7], $data[8], $data[9], $data[10], $data[11], $data[12], $data[13], $data[14], 
  $data[15], $data[16], $data[17], $data[18], $data[19], $data[20], $data[21], $data[22], 
  $data[23], $data[24], $data[25], $data[26], $data[27], $data[28], $data[29], $data[30], 
  $data[31], $data[32], $data[33], $data[34], $data[35], $data[36], $data[37], $data[38], 
  $data[39], $data[40], $data[41], $data[42], $data[43], $data[44], $data[45], $data[46], 
  $data[47], $data[48], $data[49], $data[50], $data[51], $data[52], $data[53]]);
}

/* Guarda el fichero filtrado en la base de datos */
$contacts->addNewHistoryParts($addHistory);
