<?php
$data = file_get_contents("../json/correos.json");
$products = json_decode($data, true);

$products[$_POST['center']] = str_replace("\r\n",';',$_POST['bcc']);
$products[$_POST['center'].'C'] = str_replace("\r\n",';',$_POST['cc']);
$products[$_POST['center'].'F'] = str_replace("\r\n",';',$_POST['fcc']);
$products[$_POST['center'].'ORIGEN'] = str_replace("\r\n",';',$_POST['origen']);

$newJson = $products;

file_put_contents("../json/correos.json", json_encode($newJson));