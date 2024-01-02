<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$inputnumbers = 20;
$arrayFrases = array();
for($i = 0; $i < $inputnumbers; $i++)
  array_push($arrayFrases,$_POST['clave'.$i]);
$contacts->updateClavesRef($arrayFrases);

