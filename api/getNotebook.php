<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$search = str_replace("'","",$_POST['search']);
$rows = $contacts->getNotebook($search);
$style = "style='grid-template-columns:10% 15% 15% 25% 15% 10%;padding: 0;'";

function formatRef($referencia){
  $contacts = new Contacts();
  return $contacts->formatRef($referencia);
}

$imgs = new stdClass();
$imgs->MULTIMARCA = "logo-psa.png";
$imgs->TOTAL = "logo-psa.png";
$imgs->PSA = "logo-psa.png";
$imgs->FIAT = "list_logo.jpg";
$imgs->GENERICO = "logo-psa.png";
$imgs->GENÉRICOS = "logo-psa.png";
$imgs->RENAULT = "logo-psa.png";
$imgs->TUNAP = "logo-psa.png";
$imgs->CITROEN = "Citroen_Brand_Block_RVB.svg";
$imgs->PEUGEOT = "AP.jpg";
$imgs->OPEL = "Opel.png";
$imgs->CHEVROLET = "CT.png";
$imgs->DS = "DS.jpg";
$imgs->EUROREPAR = "EUROREPAR.png";
$imgs->POWER = "distrigo.png";
$imgs->DOCUMENTOS = "docs.png";
$imgs->LEAPMOTOR = "leapmotor.svg";

$icons = new stdClass();
$icons->pdf = "./../img/pdf.png";
$icons->xls = "./../img/excel.png";
$icons->xlsx = "./../img/excel.png";
$icons->xlsm = "./../img/excel.png";
$icons->doc = "./../img/word.png";
$icons->docx = "./../img/word.png";
$icons->pptx = "./../img/power.png";
$icons->zip = "./../img/zip.png";

$htmlList = "

<div class='notebook-list-container'>
<ul class='heading'".$style.">
  <li>Marca</li>
  <li>Fichero</li>
  <li>Modelo</li>
  <li>Descripción</li>
  <li>Referencia</li>
  <li>Acciones</li>
</ul>";


foreach ($rows as $row) {
  $marca = 'MULTIMARCA';
  if($row[1] != '')
    $marca = $row[1];
  if ($row[1] == 'FIAT/JEEP')
    $marca = "FIAT";
    
  $ext = array("pdf", "xls", "xlsx", "xlsm", "doc", "docx", "pptx", "zip");
  $iconExt = explode('.',$row[5])[count(explode('.',$row[5]))-1];
  $icono = "";

  if(in_array($iconExt, $ext))
    $icono = $icons->$iconExt;
  
  if($icono == '')
    $icono = './../docs/thumb_'.$row[5];
  
  $invert = '';
  if($imgs->$marca == 'logo-psa.png')
    $invert = 'style="filter: invert(1)"';

  $file = "";
  if($row[5] != "")
    $file = '<div class="openFile" title="'.$row[5].'" ><img alt="'.substr($row[5], -10).'" src="'.$icono.'" loading="lazy"></div>';
  $htmlList .='
    <ul class="notebook-row" '.$style.'>
      <li data-label="Marca"><img src="../img/'.$imgs->$marca.'" alt="'.$row[1].'" '.$invert.' class="iconBrand" loading="lazy"></li>
      <li data-label="Fichero">'.$file.'</li>
      <li data-label="Modelo">'.strtoupper($row[2]).'</li>
      <li data-label="Descripción">'.strtoupper($row[3]).'</li>
      <li data-label="Referencia"><span title="'.$row[4].'" class="copy">'.formatRef(strtoupper($row[4])).'</span></li>
      <li data-label="Acciones" class="delete">
        <span title="eliminar registro '.$row[3].' ('.$row[4].')" id="'.$row[0].'">
          <img id="delete" alt="eliminar" src="../../img/delete_FILL0_wght400_GRAD0_opsz24.png" loading="lazy">
        </span>
        <span title="Editar registro '.$row[3].' ('.$row[4].')" id="'.$row[0].'">
          <img id="edit" alt="editar" src="../../img/edit_square_FILL0_wght400_GRAD0_opsz24.png" loading="lazy">
        </span>
      </li>
    </ul>';
}

$htmlList .= "</div>";
echo $htmlList;