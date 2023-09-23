<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->getNotebook($_POST['search']);
$style = "style='grid-template-columns:10% 15% 15% 25% 15% 10%;'";

$imgs = new stdClass();
$imgs->MULTIMARCA = "logo-psa.png";
$imgs->CITROEN = "AC.jpg";
$imgs->PEUGEOT = "AP.jpg";
$imgs->OPEL = "Opel.png";
$imgs->CHEVROLET = "CT.png";
$imgs->DS = "DS.jpg";
$imgs->EUROREPAR = "EUROREPAR.png";
$imgs->DOCUMENTOS = "docs.png";

$htmlList = "
<ul class='heading'".$style.">
  <li>Fichero</li>
  <li>Marca</li>
  <li>Modelo</li>
  <li>Descripción</li>
  <li>Reerencia</li>
  <li><div id='addNotebook' class='btn-plus' title='Añadir registro'>+</div></li>
</ul>";

foreach ($rows as $row) {
  $marca = 'MULTIMARCA';
  if($row[1] == "PEUGEOT")
    $marca = 'PEUGEOT';
  if($row[1] == "CITROEN")
    $marca = 'CITROEN';
  if($row[1] == "OPEL")
    $marca = 'OPEL';
  if($row[1] == "CHEVROLET")
    $marca = 'CHEVROLET';
  if($row[1] == "DS")
    $marca = 'DS';
  if($row[1] == "EUROREPAR")
    $marca = 'EUROREPAR';
  if($row[1] == "DOCUMENTOS")
    $marca = 'DOCUMENTOS';
  
  $invert = '';
  if($marca == 'MULTIMARCA')
    $invert = 'style="filter: invert(1)"';

  $file = "";
  if($row[5] != "")
  //$file = '<a href="../docs/'.$row[5].'" alt="'.$row[5].'" target="_blank">'.substr($row[5], -10).'</a>';
  $file = '<div class="openFile" title="'.$row[5].'" ><img alt="'.substr($row[5], -10).'" src="./../docs/thumb_'.$row[5].'"></div>';
  $htmlList .='
    <ul '.$style.'>
      <li>'.$file.'</li>
      <li><img src="../img/'.$imgs->$marca.'" alt="'.$row[1].'" '.$invert.'></li>
      <li>'.$row[2].'</li>
      <li>'.$row[3].'</li>
      <li>'.$row[4].'</li>
      <li title="Correo: " class="delete">
        <span title="eliminar registro '.$row[3].' ('.$row[4].')" id="'.$row[0].'">
          <img id="delete" alt="eliminar" src="../../img/delete_FILL0_wght400_GRAD0_opsz24.png">
        </span>
        <span title="Editar registro '.$row[3].' ('.$row[4].')" id="'.$row[0].'">
          <img id="edit" alt="editar" src="../../img/edit_square_FILL0_wght400_GRAD0_opsz24.png">
        </span>
      </li>
    </ul>';
}

echo $htmlList;