<?php

$mailDestino = $_POST['mailDestino'];
$mailFragil = $_POST['mailFragil'];
$mailSaludo = $_POST['mailSaludo'];
$destinoFragil = $_POST['destinoFragil'];
$mailOrigen = $_POST['mailOrigen'];
$mailSub = $_POST['mailSub'];
$cc = $_POST['cc'];
$mailTarget = $_POST['mailTarget'];

$fileName = rand();

$cadena = $destinoFragil.$mailDestino.$mailOrigen.'?subject='.$mailSub.'&cc='.$cc.'&body='.$mailFragil.$mailSaludo.$mailTarget.'"';

$fh = fopen($fileName.'.bat', 'w') or die('Error al cerear el archivo');
fwrite($fh,'start "" "mailto:'.$cadena);

echo $fileName;