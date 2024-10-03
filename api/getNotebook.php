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
<ul class='heading'".$style.">
  <li>Marca</li>
  <li>Fichero</li>
  <li>Modelo</li>
  <li>Descripción</li>
  <li>Reerencia</li>
  <li></li>
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
    $file = '<div class="openFile" title="'.$row[5].'" ><img alt="'.substr($row[5], -10).'" src="'.$icono.'"></div>';
  $htmlList .='
    <ul '.$style.'>
      <li><img src="../img/'.$imgs->$marca.'" alt="'.$row[1].'" '.$invert.' class="iconBrand"></li>
      <li>'.$file.'</li>
      <li>'.strtoupper($row[2]).'</li>
      <li>'.strtoupper($row[3]).'</li>
      <li title="'.$row[4].'" class="copy">'.formatRef(strtoupper($row[4])).'</li>
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