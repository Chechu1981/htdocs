<?php
include_once '../connection/data.php';

$lists = '';
$contacts = new Contacts();

$rows = $contacts->getCenter(strtoupper($_POST['center']),strtoupper($_POST['search']));
$style = "";
if(strtoupper($_POST['center']) == 'CENTROS'){
    $style = "grid-template-columns: 5% 5% 5% 18% 18% 5% 5% 5% 10% 15% 5%;'";
}


$lists ="<ul class='heading'".$style.">";
if(strtoupper($_POST['center']) == 'CENTROS'){
    $lists .= "<li>Centro</li>";
}
$lists .="<li>Entidad</li>
          <li>Equipo</li>
          <li>Nombre</li>
          <li>Puesto</li>
          <li>Ext</li>
          <li>Nº Largo</li>
          <li>Móvil</li>
          <li>Nº Corto</li>
          <li>Correo</li>
          <li><div id='addContact' class='btn-plus' title='Añadir registro'>+</div></li>
        </ul>";
$centro = "";
foreach($rows as $row){  
  $jefes = "";
  $centrolist = "";
  if(strtoupper($_POST['center']) == 'CENTROS' && $centro != $row[1]){
    $centro = $row[1];
    $centrolist = '<h3 title="Centro: " class="titleCenter">'.$row[1].'</h3>';
  }
  if(strpos($row[5],"JEFE") != '' || strpos($row[5],"RESPONSABLE") != ''){
    $jefes = "class='jefes'";
  }
  $lists .= $centrolist.'<ul '.$style.$jefes.'>';
    $lists .= '
            <li title="Entidad: ">'.$row[2].'</li>
            <li title="Equipo: ">'.$row[3].'</li>
            <li title="Nombre: ">'.$row[4].'</li>
            <li title="Puesto: ">'.$row[5].'</li>
            <li title="Ext: ">'.$row[6].'</li>
            <li title="Nº Largo: " class="copy">'.str_replace(" ","",$row[7]).'</li>
            <li title=Móvil: " class="copy">'.str_replace(" ","",$row[8]).'</li>
            <li title="Nº Corto: " class="copy">'.$row[9].'</li>
            <li title="Correo: " class="copy">'.strtolower($row[10]).'</li>
            <li title="opciones: " class="delete">
                <span title="eliminar registro '.$row[1].'" id="'.$row[0].'">
                    <img id="delete" alt="eliminar" src="../../img/delete_FILL0_wght400_GRAD0_opsz24.png">
                </span>
                <span title="Editar registro '.$row[1].'" id="'.$row[0].'">
                <img id="edit" alt="editar" src="../../img/edit_square_FILL0_wght400_GRAD0_opsz24.png">
                </span>
            </li>
        </ul>';
}

echo $lists;