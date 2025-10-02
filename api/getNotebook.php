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
<style>
.notebook-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 1.5rem;
  padding: 1rem;
  animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.notebook-card {
  background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: 1px solid #e9ecef;
  position: relative;
  overflow: hidden;
  cursor: pointer;
}

.notebook-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
  transform: scaleX(0);
  transition: transform 0.3s ease;
}

.notebook-card:hover::before {
  transform: scaleX(1);
}

.notebook-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.15);
}

.card-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #e9ecef;
}

.brand-logo {
  width: 48px;
  height: 48px;
  object-fit: contain;
  border-radius: 8px;
  padding: 0.5rem;
  background: #f8f9fa;
}

.card-title {
  flex: 1;
  font-weight: 600;
  font-size: 1.1rem;
  color: #2c3e50;
  text-transform: uppercase;
}

.card-body {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.card-field {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.field-label {
  font-size: 0.75rem;
  font-weight: 600;
  color: #6c757d;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  min-width: 80px;
}

.field-value {
  flex: 1;
  font-size: 0.95rem;
  color: #495057;
  word-break: break-word;
}

.file-preview {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  background: #f8f9fa;
  border-radius: 8px;
  transition: all 0.2s;
  cursor: pointer;
}

.file-preview:hover {
  background: #e9ecef;
  transform: scale(1.05);
}

.file-preview img {
  width: 32px;
  height: 32px;
  object-fit: contain;
}

.card-actions {
  display: flex;
  gap: 0.5rem;
  margin-top: 1rem;
  padding-top: 1rem;
  border-top: 1px solid #e9ecef;
  justify-content: flex-end;
}

.action-btn {
  padding: 0.5rem;
  border-radius: 8px;
  background: #f8f9fa;
  border: none;
  cursor: pointer;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.action-btn:hover {
  background: #e9ecef;
  transform: scale(1.1);
}

.action-btn img {
  width: 20px;
  height: 20px;
}

.reference-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.reference-badge:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

@media (max-width: 768px) {
  .notebook-container {
    grid-template-columns: 1fr;
    gap: 1rem;
    padding: 0.5rem;
  }
}
</style>
<div class='notebook-container'>";


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
  $fileDisplay = "";
  if($row[5] != "") {
    $fileName = substr($row[5], 0, 20) . (strlen($row[5]) > 20 ? '...' : '');
    $fileDisplay = '<div class="file-preview openFile" title="'.$row[5].'">
      <img alt="'.substr($row[5], -10).'" src="'.$icono.'" loading="lazy">
      <span style="font-size: 0.85rem; color: #495057;">'.$fileName.'</span>
    </div>';
  }
  
  $htmlList .='
    <div class="notebook-card">
      <div class="card-header">
        <img src="../img/'.$imgs->$marca.'" alt="'.$row[1].'" '.$invert.' class="brand-logo" loading="lazy">
        <div class="card-title">'.$marca.'</div>
      </div>
      <div class="card-body">
        '.($row[2] ? '<div class="card-field">
          <span class="field-label">Modelo</span>
          <span class="field-value">'.strtoupper($row[2]).'</span>
        </div>' : '').'
        '.($row[3] ? '<div class="card-field">
          <span class="field-label">Descripción</span>
          <span class="field-value">'.strtoupper($row[3]).'</span>
        </div>' : '').'
        '.($row[4] ? '<div class="card-field">
          <span class="field-label">Referencia</span>
          <span class="reference-badge copy" title="'.$row[4].'">'.formatRef(strtoupper($row[4])).'</span>
        </div>' : '').'
        '.($fileDisplay ? '<div class="card-field">
          <span class="field-label">Archivo</span>
          '.$fileDisplay.'
        </div>' : '').'
      </div>
      <div class="card-actions">
        <button class="action-btn delete" title="Eliminar registro '.$row[3].' ('.$row[4].')" id="'.$row[0].'">
          <img id="delete" alt="eliminar" src="../../img/delete_FILL0_wght400_GRAD0_opsz24.png" loading="lazy">
        </button>
        <button class="action-btn" title="Editar registro '.$row[3].' ('.$row[4].')" id="'.$row[0].'">
          <img id="edit" alt="editar" src="../../img/edit_square_FILL0_wght400_GRAD0_opsz24.png" loading="lazy">
        </button>
      </div>
    </div>';
}

$htmlList .= "</div>";
echo $htmlList;